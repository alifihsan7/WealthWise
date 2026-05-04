# Gunakan image resmi PHP 8.2 dengan Apache
FROM php:8.2-apache

# Instal dependensi sistem dan ekstensi PostgreSQL (Wajib untuk Neon.tech)
RUN apt-get update && apt-get install -y \
    libpq-dev \
    unzip \
    git \
    && docker-php-ext-install pdo pdo_pgsql

# Aktifkan mod_rewrite Apache (Penting agar routing Laravel berfungsi)
RUN a2enmod rewrite

# Ubah Document Root Apache agar menunjuk ke folder /public Laravel
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Salin seluruh kode proyek Anda ke dalam container
COPY . /var/www/html

# Instal Composer dan jalankan instalasi dependensi Laravel
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN composer install --no-dev --optimize-autoloader

# Berikan hak akses ke folder yang membutuhkan write-permission
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Buka port 80
EXPOSE 80