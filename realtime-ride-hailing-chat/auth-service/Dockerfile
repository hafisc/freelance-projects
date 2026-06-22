# Gunakan base image Node.js yang ringan
FROM node:18-alpine

# Set working directory di dalam container
WORKDIR /usr/src/app

# Salin package.json dan package-lock.json untuk instalasi dependencies
COPY package*.json ./

# Install dependensi
RUN npm install

# Salin seluruh kode program service
COPY . .

# Ekspos port 3000
EXPOSE 3000

# Jalankan service
CMD ["npm", "start"]
