FROM php:8.1-apache

# Enable Apache modules if needed
RUN a2enmod rewrite

# Set document root
WORKDIR /var/www/html

# Copy files to container
COPY . .

# Set proper permissions
RUN chown -R www-data:www-data /var/www/html/uploads

# Expose port 80
EXPOSE 80

CMD ["apache2-foreground"]
