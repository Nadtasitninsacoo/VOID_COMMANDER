FROM php:8.2-apache

# 1. ติดตั้ง System Dependencies
RUN apt-get update && apt-get install -y \
    libpng-dev libonig-dev libxml2-dev zip unzip git libpq-dev gnupg

# 2. ติดตั้ง Node.js 20
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs

# 3. ติดตั้ง PHP Extensions
RUN docker-php-ext-install pcntl bcmath gd pdo pdo_pgsql

# ตั้งค่า Apache
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/000-default.conf
RUN a2enmod rewrite

# ก๊อปปี้โปรเจกต์
COPY . /var/www/html
WORKDIR /var/www/html

# 4. ติดตั้ง PHP Dependencies (Composer)
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN composer install --no-dev --optimize-autoloader

# 5. ติดตั้ง JS Dependencies และ BUILD ASSETS (สำคัญที่สุด!)
RUN npm install
RUN npm run build

# 6. ตั้งสิทธิ์ไฟล์ให้ www-data (ครอบคลุมทั้ง storage และ public)
# เพื่อให้ Apache อ่านไฟล์ที่ Vite สร้างขึ้นมาได้
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache /var/www/html/public

ENTRYPOINT ["sh", "-c", "php artisan migrate:fresh --force --seed && apache2-foreground"]
