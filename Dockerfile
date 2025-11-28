FROM php:8.2-apache

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Install and enable pdo_mysql
RUN docker-php-ext-install pdo_mysql

# Set working directory
WORKDIR /var/www/html

# Set ServerName to suppress warning
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

# Create custom Apache configuration for DocumentRoot
RUN echo "<VirtualHost *:80>\n\
    DocumentRoot /var/www/html/public\n\
    <Directory /var/www/html/public>\n\
        AllowOverride All\n\
        Require all granted\n\
    </Directory>\n\
</VirtualHost>" > /etc/apache2/sites-available/000-default.conf