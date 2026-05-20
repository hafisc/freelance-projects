# Requirements Document

## Introduction

This document defines the requirements for a WhatsApp AI Chatbot running on Raspberry Pi 3. The system uses Node.js with Baileys for WhatsApp connectivity, PicoClaw CLI as the AI agent interface, and Gemini API (configured through PicoClaw) for generating responses. The chatbot is designed for personal/internal/prototype use, running as a systemd service with auto-start on boot.

## Glossary

- **Bot**: The WhatsApp AI Chatbot application that receives messages and responds with AI-generated replies
- **Baileys**: The @whiskeysockets/baileys library used for WhatsApp Web API connectivity
- **PicoClaw**: A CLI tool that acts as the AI agent, configured to use Gemini API for generating responses
- **Auth_State**: The multi-file authentication state stored in the `auth_info_baileys` directory for WhatsApp session persistence
- **Command_Prefix**: A configurable text prefix (default `!ai`) that triggers the Bot to process a message as an AI query
- **Whitelist**: A list of allowed phone numbers configured via .env; when empty, all numbers are permitted
- **Raspberry_Pi**: The Raspberry Pi 3 hardware platform running Raspberry Pi OS Lite 64-bit or Linux Debian/Ubuntu
- **Systemd_Service**: A Linux systemd unit file that manages the Bot process lifecycle including auto-start on boot
- **Active_Job**: A per-user tracking mechanism that prevents concurrent command processing for the same user
- **Message_Splitter**: A utility that breaks long AI replies into multiple WhatsApp messages by splitting at newline or space boundaries

## Requirements

### Requirement 1: Environment Verification

**User Story:** As a developer, I want to verify that my Raspberry Pi environment has all required dependencies, so that I can ensure the system is ready for deployment.

#### Acceptance Criteria

1. WHEN the `check-env.sh` script is executed, THE Bot SHALL verify the presence and version of Node.js (major version 20 or newer)
2. WHEN the `check-env.sh` script is executed, THE Bot SHALL verify the presence of npm (any version bundled with the installed Node.js)
3. WHEN the `check-env.sh` script is executed, THE Bot SHALL verify the presence of PicoClaw CLI at the path specified by the `PICOCLAW_BIN` environment variable
4. WHEN the `check-env.sh` script is executed, THE Bot SHALL verify the operating system is Raspberry Pi OS, Debian, or Ubuntu
5. IF any dependency is missing or incompatible, THEN THE Bot SHALL display an error message that identifies the failed dependency by name and provides a resolution instruction, and SHALL exit with a non-zero exit code
6. WHEN all dependency checks pass, THE Bot SHALL print a summary listing each verified dependency with its detected version and SHALL exit with exit code 0
7. WHEN multiple dependencies are missing or incompatible, THE Bot SHALL check all dependencies and report all failures in a single execution rather than stopping at the first failure

### Requirement 2: Node.js Installation

**User Story:** As a developer, I want an automated script to install Node.js 20 LTS on my Raspberry Pi, so that I can quickly set up the runtime environment.

#### Acceptance Criteria

1. WHEN the `install-node.sh` script is executed, THE Bot SHALL detect the system architecture (arm64 or armv7l) and install Node.js 20 LTS using the NodeSource repository for that architecture
2. WHEN the `install-node.sh` script is executed, IF Node.js major version 20 is already installed, THEN THE Bot SHALL skip installation and report the currently installed version
3. WHEN the installation completes, THE Bot SHALL verify success by executing `node --version` and confirming the output indicates Node.js major version 20
4. IF the script is executed without root or sudo privileges, THEN THE Bot SHALL display an error message indicating that elevated privileges are required and exit without modifying the system
5. IF the installation fails due to network error, repository unavailability, or package manager error, THEN THE Bot SHALL display an error message indicating the failure reason and provide troubleshooting steps including verifying internet connectivity and NodeSource repository availability

### Requirement 3: PicoClaw CLI Installation and Configuration

**User Story:** As a developer, I want to install and configure PicoClaw CLI as the AI agent, so that the bot can generate AI responses via Gemini API.

#### Acceptance Criteria

1. WHEN the `install-picoclaw.sh` script is executed, THE Bot SHALL install PicoClaw CLI to the path specified by the `PICOCLAW_BIN` environment variable (default: `/usr/local/bin/picoclaw`)
2. IF the `install-picoclaw.sh` script fails to install PicoClaw CLI (download error, permission denied, or checksum mismatch), THEN THE Bot SHALL display an error message indicating the failure reason and exit with a non-zero status code
3. THE Bot SHALL use PicoClaw CLI exclusively for AI processing by invoking `picoclaw agent -m "<prompt>"`
4. THE Bot SHALL NOT make direct API calls to Gemini or any other AI provider
5. WHEN the Bot starts, THE Bot SHALL verify that PicoClaw CLI exists and is executable at the configured `PICOCLAW_BIN` path, and IF PicoClaw CLI is not found or not executable, THEN THE Bot SHALL log an error and refuse to process AI commands

### Requirement 4: WhatsApp Connection via Baileys

**User Story:** As a developer, I want the bot to connect to WhatsApp using Baileys with persistent session storage, so that I don't need to rescan the QR code after every restart.

#### Acceptance Criteria

1. WHEN the Bot starts and no Auth_State exists in the configured `BAILEYS_AUTH_DIR` directory, THE Bot SHALL display a QR code in the terminal using qrcode-terminal
2. WHEN the Bot starts and the Auth_State files exist and are loadable by Baileys `useMultiFileAuthState` in the configured `BAILEYS_AUTH_DIR` directory, THE Bot SHALL reconnect without displaying a QR code
3. THE Bot SHALL persist the Auth_State using Baileys multi-file auth state to the configured `BAILEYS_AUTH_DIR` directory
4. WHEN the Auth_State is updated by Baileys via the `saveCreds` callback, THE Bot SHALL write the updated credentials to disk before returning from the callback
5. IF the Bot fails to write Auth_State to the configured `BAILEYS_AUTH_DIR` directory due to a filesystem error, THEN THE Bot SHALL log an error indicating the write failure and the directory path

### Requirement 5: Command Prefix Processing

**User Story:** As a developer, I want messages to be processed only when they start with a configurable command prefix, so that the bot doesn't respond to every message.

#### Acceptance Criteria

1. WHEN a message starts with the configured Command_Prefix (default `!ai`) using case-sensitive matching, THE Bot SHALL extract the text after the prefix, trim leading whitespace, and process it as an AI query
2. WHEN a message does not start with the Command_Prefix, THE Bot SHALL ignore the message without any response
3. IF the `COMMAND_PREFIX` environment variable is not set or is empty, THEN THE Bot SHALL use the default value `!ai`
4. WHEN the extracted query text after the prefix is empty or contains only whitespace characters, THE Bot SHALL reply with a usage hint message indicating the correct command format and the current prefix in use

### Requirement 6: Whitelist Number Filtering

**User Story:** As a developer, I want to restrict which phone numbers can use the bot, so that I can control access during testing and deployment.

#### Acceptance Criteria

1. WHEN the `ALLOWED_NUMBERS` environment variable contains a comma-separated list of phone numbers in international format without the plus sign (e.g., `6281234567890,6289876543210`), THE Bot SHALL only process messages from those numbers after trimming whitespace from each entry
2. WHEN the `ALLOWED_NUMBERS` environment variable is empty or not defined, THE Bot SHALL process messages from all numbers (open access mode for testing)
3. WHEN a message arrives from a non-whitelisted number and the Whitelist is active, THE Bot SHALL ignore the message without any response and log the rejection at debug level only

### Requirement 7: AI Query Processing via PicoClaw

**User Story:** As a developer, I want the bot to send user questions to PicoClaw CLI and return the AI response, so that users get intelligent replies via WhatsApp.

#### Acceptance Criteria

1. WHEN a valid AI query is received, THE Bot SHALL invoke PicoClaw CLI using `execFile` with the command `picoclaw agent -m "<sanitized_prompt>"`, where sanitization removes shell metacharacters and trims leading/trailing whitespace from the user input
2. WHEN PicoClaw CLI returns a zero exit code, THE Bot SHALL send the content of stdout back to the originating WhatsApp chat, ignoring stderr output
3. THE Bot SHALL set a timeout of `PICOCLAW_TIMEOUT_MS` milliseconds (default 120000) for PicoClaw CLI execution
4. IF PicoClaw CLI exceeds the configured timeout, THEN THE Bot SHALL terminate the child process and reply with an error message indicating the request timed out
5. IF PicoClaw CLI returns a non-zero exit code, THEN THE Bot SHALL reply with a generic error message without exposing internal details such as exit codes or stderr content
6. IF PicoClaw CLI returns a zero exit code but stdout is empty or contains only whitespace, THEN THE Bot SHALL reply with an error message indicating no response was generated

### Requirement 8: Composing Status Indicator

**User Story:** As a developer, I want the bot to show a "composing" status while processing, so that users know the bot is working on their request.

#### Acceptance Criteria

1. WHEN the Bot begins invoking PicoClaw CLI for an AI query, THE Bot SHALL send a "composing" presence update to the originating chat
2. WHEN the Bot finishes processing and sends the reply, THE Bot SHALL stop the composing presence update before sending the first message segment
3. IF PicoClaw CLI execution fails due to timeout, non-zero exit code, or any other error, THEN THE Bot SHALL stop the composing presence update before sending the error reply

### Requirement 9: Input and Output Message Validation

**User Story:** As a developer, I want to enforce message length limits, so that the system doesn't process excessively long inputs or produce oversized outputs.

#### Acceptance Criteria

1. WHEN an incoming message exceeds `MAX_CHARS` characters (default 1500) measured on the full message text including the Command_Prefix, THE Bot SHALL reject the message and reply with an error message indicating the character limit and the actual message length
2. WHEN a PicoClaw response exceeds `MAX_REPLY_CHARS` characters (default 3500), THE Bot SHALL split the response into multiple messages using the Message_Splitter, preferring split points at newline boundaries first, then at space boundaries
3. IF a segment produced by the Message_Splitter contains no newline or space boundary within the `MAX_REPLY_CHARS` limit, THEN THE Bot SHALL hard-split the segment at exactly `MAX_REPLY_CHARS` characters to ensure no content is lost

### Requirement 10: Message Splitting for Long Replies

**User Story:** As a developer, I want long AI replies to be split into multiple WhatsApp messages, so that users receive complete responses without truncation.

#### Acceptance Criteria

1. WHEN a response exceeds `MAX_REPLY_CHARS` characters (default 3500), THE Message_Splitter SHALL divide the text into segments that each contain at most `MAX_REPLY_CHARS` characters
2. THE Message_Splitter SHALL split at the last newline character within the segment limit first; IF no newline is found within the limit, THEN THE Message_Splitter SHALL split at the last space character; IF no space is found within the limit, THEN THE Message_Splitter SHALL split at exactly the character limit
3. THE Message_Splitter SHALL send each segment sequentially in order with a delay of 500 milliseconds between messages
4. THE Message_Splitter SHALL preserve the original text content completely, such that concatenating all segments in order reproduces the original response without truncation or loss
5. IF the response would produce more than 10 segments, THEN THE Message_Splitter SHALL send only the first 10 segments and append a final message indicating the response was too long to deliver in full

### Requirement 11: Auto-Reconnect on Disconnection

**User Story:** As a developer, I want the bot to automatically reconnect when WhatsApp disconnects temporarily, so that the service remains available without manual intervention.

#### Acceptance Criteria

1. WHEN a temporary WhatsApp disconnection occurs (connection closed, network timeout), THE Bot SHALL attempt to reconnect automatically using the existing Auth_State, with a maximum of 5 consecutive retry attempts
2. WHEN retrying a temporary disconnection, THE Bot SHALL wait at least 3 seconds between consecutive reconnection attempts
3. WHEN a permanent logout event occurs (logged out from phone, session revoked), THE Bot SHALL stop reconnection attempts, delete the Auth_State from the `BAILEYS_AUTH_DIR` directory, and log the event at error level
4. THE Bot SHALL use @hapi/boom to classify disconnection reasons: a statusCode in the 400-499 range with `DisconnectReason.loggedOut` indicates a permanent logout; all other disconnection reasons are treated as temporary
5. IF all 5 reconnection attempts are exhausted without success, THEN THE Bot SHALL log a fatal error and terminate the process with a non-zero exit code, allowing the Systemd_Service to restart it

### Requirement 12: Anti-Spam Active Job Tracking

**User Story:** As a developer, I want to prevent users from sending multiple commands simultaneously, so that the system resources are not overwhelmed.

#### Acceptance Criteria

1. WHILE an Active_Job is being processed for a specific user, THE Bot SHALL reject new commands from that user with a "please wait" message before consuming any processing resources
2. WHEN the Active_Job completes (success, failure, or timeout), THE Bot SHALL remove the user from the active job tracker immediately
3. THE Bot SHALL track Active_Jobs per user phone number independently
4. IF an Active_Job entry has been present for longer than `PICOCLAW_TIMEOUT_MS` plus 10 seconds without completion, THEN THE Bot SHALL automatically remove the stale entry as a safety-net cleanup

### Requirement 13: Systemd Service Configuration

**User Story:** As a developer, I want the bot to run as a systemd service, so that it auto-starts on Raspberry Pi boot and restarts on failure.

#### Acceptance Criteria

1. THE Systemd_Service SHALL configure the Bot to start automatically after the network is available on boot
2. IF the Bot process exits with a non-zero exit code or is terminated by a signal, THEN THE Systemd_Service SHALL restart the Bot process after a 10-second delay, up to a maximum of 5 restart attempts within a 60-second window
3. THE Systemd_Service SHALL run the Bot under a non-root user account
4. THE Systemd_Service SHALL set the working directory to the project root and load environment from the .env file
5. IF the Bot process exceeds the maximum restart attempts within the burst window, THEN THE Systemd_Service SHALL stop restart attempts and log the failure to the systemd journal
6. THE Systemd_Service SHALL direct the Bot standard output and standard error to the systemd journal

### Requirement 14: Secure Process Execution

**User Story:** As a developer, I want all external process calls to use secure execution methods, so that command injection vulnerabilities are prevented.

#### Acceptance Criteria

1. THE Bot SHALL use `execFile` from Node.js `child_process` module for all PicoClaw CLI invocations
2. THE Bot SHALL NOT use `exec` or `spawn` with shell option enabled for any external process execution
3. THE Bot SHALL pass all arguments as array elements to `execFile`, not as concatenated strings
4. THE Bot SHALL NOT store any secrets, API keys, or credentials in files tracked by version control, and SHALL load all secrets exclusively from environment variables
5. WHEN constructing arguments for PicoClaw CLI execution, THE Bot SHALL pass the user-provided prompt text as a single array element without shell interpolation or string concatenation with other arguments
6. THE Bot SHALL NOT pass parent process environment variables containing secrets (API keys, credentials) to child processes unless explicitly required by PicoClaw CLI execution

### Requirement 15: Configuration Management

**User Story:** As a developer, I want all configuration to be managed through environment variables, so that the bot is portable and secrets are not committed to version control.

#### Acceptance Criteria

1. THE Bot SHALL load configuration from environment variables using the dotenv package, falling back to system environment variables if no `.env` file is present
2. THE Bot SHALL provide a `.env.example` file documenting all available configuration variables with their default values, including: `COMMAND_PREFIX`, `ALLOWED_NUMBERS`, `PICOCLAW_BIN`, `PICOCLAW_TIMEOUT_MS`, `MAX_CHARS`, `MAX_REPLY_CHARS`, `LOG_LEVEL`, and `BAILEYS_AUTH_DIR`
3. WHEN the Bot starts, THE Bot SHALL validate that all required configuration variables (`PICOCLAW_BIN`) are present and non-empty
4. IF any required configuration variable is missing or empty on startup, THEN THE Bot SHALL exit with a non-zero exit code and print an error message to stderr listing each missing variable by name
5. THE Bot SHALL include `.env` and `auth_info_baileys/` in the `.gitignore` file

### Requirement 16: Logging

**User Story:** As a developer, I want structured logging with configurable levels, so that I can monitor and debug the bot without exposing sensitive data.

#### Acceptance Criteria

1. THE Bot SHALL use pino for all logging output in JSON structured format
2. THE Bot SHALL respect the `LOG_LEVEL` environment variable for log verbosity (default: info); IF an invalid log level is provided, THEN THE Bot SHALL fall back to info level
3. THE Bot SHALL NOT log message content, phone numbers, or any personally identifiable information at any log level
4. WHEN logging at debug level, THE Bot SHALL include message metadata (chat ID type, message length) without full content or phone numbers

### Requirement 17: ES Module Project Structure

**User Story:** As a developer, I want the project to use ES Module syntax with a clean modular structure, so that the codebase is maintainable and follows modern Node.js practices.

#### Acceptance Criteria

1. THE Bot SHALL use ES Module syntax (`import`/`export`) with `"type": "module"` in package.json and SHALL NOT use CommonJS syntax (`require()`, `module.exports`) in any source file
2. THE Bot SHALL organize source code into the following directory structure with defined responsibilities: `src/config/` for configuration loading and validation, `src/bot/` for WhatsApp connection and message handling logic, `src/services/` for PicoClaw CLI integration and external process calls, `src/utils/` for shared utility functions including Message_Splitter, `src/constants/` for constant values and static definitions
3. THE Bot SHALL define the application entry point in `index.js` at the project root
4. THE Bot SHALL include all code comments (inline comments, file headers, and function documentation) in Bahasa Indonesia (Indonesian language)

### Requirement 18: QR Code Display

**User Story:** As a developer, I want the QR code displayed clearly in the terminal, so that I can easily scan it with my phone to link the WhatsApp account.

#### Acceptance Criteria

1. WHEN a QR code event is received from Baileys, THE Bot SHALL render the QR code in the terminal using the qrcode-terminal package with "small" output mode
2. WHEN the QR code is updated (refreshed by WhatsApp), THE Bot SHALL clear the previous QR output from the terminal and render the new QR code in its place
3. IF the QR code has been refreshed 5 times without a successful connection, THEN THE Bot SHALL stop displaying QR codes and log an error message indicating the pairing session has expired
4. WHEN the connection is successfully established after QR scan, THE Bot SHALL log a success message at info level with the connected phone number masked to show only the last 4 digits (e.g., "****1234")

### Requirement 19: Documentation

**User Story:** As a developer, I want comprehensive documentation, so that I can set up, use, and troubleshoot the bot independently.

#### Acceptance Criteria

1. THE Bot SHALL include a README.md with setup instructions for Raspberry Pi 3 covering: prerequisites (Node.js 20 LTS, npm, PicoClaw CLI, OS requirements), installation steps (cloning, dependency install, .env configuration), and service activation (systemd setup and start)
2. THE Bot SHALL document all environment variables defined in `.env.example`, including each variable's purpose, accepted values or format, and default value, in a dedicated section of the README.md
3. THE Bot SHALL include a troubleshooting section in the README.md with at least one entry for each listed issue (QR not showing, connection drops, PicoClaw errors), where each entry contains the symptom, probable cause, and resolution steps
4. THE Bot SHALL include at least 2 usage examples in the README.md showing the command prefix input message and the expected bot reply format
5. THE Bot SHALL include a "Requirements" section in the README.md listing the minimum supported versions of Node.js, npm, PicoClaw CLI, and the supported operating systems (Raspberry Pi OS Lite 64-bit, Debian, Ubuntu)

### Requirement 20: Ethical Usage Constraints

**User Story:** As a developer, I want the bot to be designed strictly for personal/prototype use, so that it cannot be misused for spam or unauthorized messaging.

#### Acceptance Criteria

1. THE Bot SHALL NOT include any broadcast, bulk messaging, or scheduled messaging functionality
2. THE Bot SHALL NOT include any scraping, contact enumeration, or data collection features beyond operational logging defined in Requirement 16
3. THE Bot SHALL NOT initiate outbound messages to any chat unless responding to a user-initiated command that matches the Command_Prefix
4. WHEN the Whitelist is configured with one or more numbers, THE Bot SHALL only process messages from those whitelisted numbers as defined in Requirement 6
5. THE Bot SHALL include a disclaimer in the README.md stating the project is for personal/internal/prototype use only and is not intended for commercial, bulk, or automated outreach purposes
6. THE Bot SHALL NOT include any functionality to send messages to groups, broadcast lists, or multiple recipients from a single command
