FROM php:8.2-apache

# ติดตั้ง System Dependencies
RUN apt-get update && apt-get install -y \
    libpng-dev libonig-dev libxml2-dev zip unzip git

# แก้ไขจาก pscntl เป็น pcntl (ลบตัว s ออก)
RUN docker-php-ext-install pcntl bcmath gd mysqli pdo pdo_mysql

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

# ตั้งสิทธิ์ไฟล์ให้ Web Server เขียนข้อมูลลง storage ได้
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

CMD ["apache2-foreground"]
