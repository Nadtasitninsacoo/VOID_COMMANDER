FROM php:8.2-apache

# 1. ติดตั้ง System Dependencies (เพิ่ม libpq-dev เข้าไป)
RUN apt-get update && apt-get install -y \
    libpng-dev libonig-dev libxml2-dev zip unzip git libpq-dev

# 2. ติดตั้ง PHP Extensions (ลบ mysqli/pdo_mysql ออก แล้วใส่ pdo_pgsql แทน)
RUN docker-php-ext-install pcntl bcmath gd pdo pdo_pgsql

# ตั้งค่า Apache ให้ชี้ไปที่โฟลเดอร์ public ของ Laravel
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/000-default.conf
RUN a2enmod rewrite

# ก๊อปปี้โค้ดโปรเจ็กต์
COPY . /var/www/html
WORKDIR /var/www/html

# ติดตั้ง Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN composer install --no-dev --optimize-autoloader

# ตั้งสิทธิ์ไฟล์
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# สั่ง Migrate และรัน Apache (ใช้รูปแบบ CMD ตัวเดียวจบ)
CMD php artisan migrate --force && apache2-foreground
