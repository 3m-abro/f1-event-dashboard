#!/bin/bash

# Set variables
IMAGE_NAME="f1-php-backend"
DEPLOYMENT_NAME="f1-php-backend"
CONTAINER_NAME="f1-php-backend"

# Use Minikube's Docker daemon
echo "Setting Minikube's Docker environment..."
eval $(minikube -p minikube docker-env)

# Rebuild Docker image
echo "Building the Docker image for $IMAGE_NAME..."
docker build -t $IMAGE_NAME:latest .

# Check if the build was successful
if [ $? -ne 0 ]; then
    echo "Docker build failed! Exiting..."
    exit 1
fi

# Update the Kubernetes deployment
echo "Updating Kubernetes deployment $DEPLOYMENT_NAME..."
kubectl set image deployment/$DEPLOYMENT_NAME $CONTAINER_NAME=$IMAGE_NAME:latest

# Check if the update was successful
if [ $? -ne 0 ]; then
    echo "Failed to update Kubernetes deployment! Exiting..."
    exit 1
fi

# Optional: Rollout restart to ensure the new image is used
echo "Restarting the deployment to ensure the new image is in use..."
kubectl rollout restart deployment/$DEPLOYMENT_NAME

# Get the status of the pods
echo "Checking the status of the pods..."
kubectl get pods

echo "Backend updated successfully!"
