class BusinessRegistration {
  // =========================
  // LOGIN & REGISTER
  // =========================

  static String phoneNumber = '';
  static String otpCode = '';

  // =========================
  // BUSINESS PROFILE
  // =========================

  static String businessName = '';

  // =========================
  // CATEGORY
  // =========================

  static String category = '';

  // =========================
  // BUSINESS HOURS
  // =========================

  static String businessHours = '';

  // =========================
  // SCHEDULE
  // =========================

  static String schedule = '';

  // =========================
  // PHOTO
  // =========================

  static String profilePhoto = '';

  // =========================
  // LOCATION
  // =========================

  static String address = '';
  static String website = '';

  // =========================
  // DESCRIPTION
  // =========================

  static String description = '';

  // =========================
  // RESET DATA
  // =========================

  static void clear() {
    phoneNumber = '';
    otpCode = '';
    businessName = '';
    category = '';
    businessHours = '';
    schedule = '';
    profilePhoto = '';
    address = '';
    website = '';
    description = '';
  }
}