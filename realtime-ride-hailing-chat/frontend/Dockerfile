# Gunakan base image Nginx alpine yang ringan
FROM nginx:alpine

# Salin konfigurasi kustom Nginx
COPY nginx.conf /etc/nginx/conf.d/default.conf

# Salin source code frontend ke folder Nginx
COPY src/ /usr/share/nginx/html/

# Ekspos port 80
EXPOSE 80

# Jalankan Nginx
CMD ["nginx", "-g", "daemon off;"]
