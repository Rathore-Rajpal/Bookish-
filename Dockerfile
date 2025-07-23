
# Use the official PHP 8.2 CLI image
FROM php:8.2-cli

# Install mysqli extension
RUN docker-php-ext-install mysqli

# Set the working directory
WORKDIR /app

# Copy all project files into the container
COPY . /app

# Expose port 10000 for Render.com
EXPOSE 10000

# Start the PHP built-in server on port 10000
CMD ["php", "-S", "0.0.0.0:10000", "-t", "."]
