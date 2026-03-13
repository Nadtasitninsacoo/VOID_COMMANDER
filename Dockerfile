FROM php:8.2-apache

# 1. ติดตั้ง System Dependencies
RUN apt-get update && apt-get install -y \
    libpng-dev libonig-dev libxml2-dev zip unzip git libpq-dev gnupg

# 2. ติดตั้ง Node.js (Version 20)
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs

# 3. ติดตั้ง PHP Extensions
RUN docker-php-ext-install pcntl bcmath gd pdo pdo_pgsql

# ตั้งค่า Apache
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/000-default.conf
RUN a2enmod rewrite

# ก๊อปปี้โค้ดทั้งหมด
COPY . /var/www/html
WORKDIR /var/www/html

# 4. ติดตั้ง PHP Dependencies
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN composer install --no-dev --optimize-autoloader

# 5. ติดตั้ง JS Dependencies และสั่ง Build Assets ทันที
# ขั้นตอนนี้จะสร้างไฟล์ /var/www/html/public/build/manifest.json ที่มันฟ้องหาครับ
RUN npm install
RUN npm run build

# 6. ตั้งสิทธิ์ไฟล์ (ทำหลังจาก build เสร็จเพื่อให้สิทธิ์ครอบคลุมไฟล์ที่สร้างใหม่)
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache /var/www/html/public

ENTRYPOINT ["sh", "-c", "php artisan migrate --force && apache2-foreground"]
