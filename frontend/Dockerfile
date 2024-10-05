# Use the official Node.js image
FROM node:18-alpine

# Set working directory
WORKDIR /app

# Copy package.json and install dependencies
COPY package*.json ./
RUN npm install

# Copy the rest of the application
COPY . .

# Copy Production .env of the application
COPY .env.production .env

# Build the app for production
RUN npm run build

# Install a simple web server to serve the Vue.js app
RUN npm install -g serve

# Expose port 8081
EXPOSE 8081

# Start the app
CMD ["serve", "-s", "dist", "-l", "8081"]
