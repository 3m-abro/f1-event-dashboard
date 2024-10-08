# F1 Event Dashboard

## Project Overview

The F1 Event Dashboard is a lightweight application that displays Formula 1 event schedules, team standings, and live race updates. This project consists of a PHP backend service, a Vue.js frontend, and is deployed using a basic Kubernetes setup.

## Architecture

The project is structured as follows:

- Backend: PHP service (Laravel framework)
- Frontend: Vue.js
- Deployment: Kubernetes (Minikube for local setup)
- CI/CD: GitHub Actions

## Features

- Display F1 event schedules
- Show team standings
- Provide live race updates using Server-Sent Events (SSE)

## Prerequisites

- Docker
- Kubernetes (Minikube for local setup)
- Node.js and npm
- PHP 8.x
- Composer

## Getting Started

### Local Development

1. Clone the repository:
   ```
   mkdir f1-dashboard
   cd f1-dashboard
   git clone https://github.com/3m-abro/f1-event-dashboard.git .
   ```

2. Set up the backend:
   ```
   cd backend
   cp .env.example .env
   composer install
   php artisan key:generate
   ```

3. Set up the frontend:
   ```
   cd ../frontend
   npm install
   ```

4. Run the development servers:
   - Backend: `php artisan serve`
   - Frontend: `npm run serve`

### Kubernetes Deployment

1. Start Minikube:
   ```
   minikube start
   ```

2. Apply Kubernetes configurations:
   ```
   kubectl apply -f k8s/
   ```

3. Enable Ingress in Minikube:
   ```
   minikube addons enable ingress
   ```

4. Update Hosts with Virtual Domains:
   ```
   sudo nano /etc/hosts

   // Add following in the hosts file
   127.0.0.1   f1-dashboard.local
   127.0.0.1   f1-backend.local
   ```
   
5. Start Minikube Tunnel to access Virtual Domains:
   ```
   minikube tunnel
   ```

6. Start Minikube Dashboard (Optional):
   ```
   // Start Minikube Dashboard to view Kubernetes Panel for pods and services. P.S. Use a new terminal.
   minikube dashboard
   ```

## API Endpoints

- `GET /api/schedule`: Retrieve F1 event schedule
- `GET /api/standings`: Get team standings
- `GET /api/live-updates`: Server-Sent Events endpoint for live race updates

## Running Tests

To run the backend tests:

```
cd backend
php artisan test
```

## CI/CD Pipeline

The project uses GitHub Actions for CI/CD. The pipeline is configured in `.github/workflows/ci-cd.yaml` and includes:

- Running backend tests
- Building Docker images
- Deploying to Kubernetes (when merged to main branch)

## Contributing

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

## License

This project is licensed under the MIT License.
