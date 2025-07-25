# Laravel + Vue To‑Do App

A simple full‑stack To‑Do application built with **Laravel 10** (REST API backend) and **Vue 3** (frontend SPA) styled with **Tailwind CSS**.  
The project is containerized with **Docker Compose** for easy setup.

---

## Features

✅ Add tasks with title and description  
✅ List latest tasks (5 most recent)  
✅ Mark tasks as completed  
✅ REST API backend (`/api/tasks`)  
✅ Vue 3 frontend with Tailwind CSS  
✅ Dockerized environment (PHP + MySQL)  
✅ Laravel Feature tests included

---

## Prerequisites

Make sure you have these installed:

- [Docker Desktop](https://www.docker.com/products/docker-desktop/) (with Docker Compose)
- [Node.js](https://nodejs.org/) v16 or higher (for frontend build)
- Git (optional)

---

## Getting Started (Docker)

1. **Clone this repository**
   ```bash
   git clone https://github.com/Hiruni60/tachnical-assessment.git
   cd tachnical-assessment

## 1. Build and start containers
docker-compose up -d --build

## 2. Run database migrations
docker-compose exec app php artisan migrate

## 3. Run the Laravel backend
docker-compose exec app php artisan serve --host=0.0.0.0

## 4. Run the Vue frontend (in another terminal )
npm install
npm run dev

## Running Tests
docker-compose exec app php artisan test

