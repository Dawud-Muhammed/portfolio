# Dawud Muhammed — Premium Laravel Portfolio Platform

[![Laravel](https://img.shields.io/badge/Laravel-13-red?logo=laravel)](https://laravel.com/)
[![PHP](https://img.shields.io/badge/PHP-8.4-blue?logo=php)](https://www.php.net/)
[![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-3.x-38B2AC?logo=tailwind-css)](https://tailwindcss.com/)
[![Vite](https://img.shields.io/badge/Vite-Frontend_Build_Tool-646CFF?logo=vite)](https://vitejs.dev/)
[![License](https://img.shields.io/badge/License-MIT-green.svg)](LICENSE)

A premium, recruiter-friendly portfolio platform built with **Laravel**, **Tailwind CSS**, **Alpine.js**, and **Vite**.  
This project is more than a static portfolio — it is a full content-driven personal brand platform with an **admin dashboard**, **project showcase**, **blog**, **testimonials**, **contact workflow**, and **SEO-focused enhancements**.

---

## Overview

This portfolio was built to present technical work with the same care as a production product.

It combines:
- a polished public-facing portfolio experience
- a manageable admin backend
- structured content for projects and blog posts
- responsive UI and premium visual styling
- portfolio-specific SEO features like sitemap, robots, and Open Graph image generation

---

## Key Features

### Public Portfolio Experience
- Premium hero section with strong personal branding
- About section with skills highlights
- Filterable featured projects showcase
- Dedicated project detail pages
- Blog listing and individual blog post pages
- Testimonials carousel
- Contact form with API submission flow
- Responsive layout with modern portfolio styling

### Admin & Content Management
- Secure admin login
- Admin dashboard with portfolio activity overview
- CRUD for projects
- CRUD for blog posts
- CRUD for categories
- CRUD for skills
- CRUD for testimonials
- Site settings management
- Contact inbox and reply workflow

### Technical & Product Features
- Laravel 13 backend architecture
- Alpine.js interactions for a lightweight reactive frontend
- Tailwind CSS design system
- Vite asset pipeline
- API endpoints for projects and contact submission
- Sitemap and robots endpoints
- Open Graph image generation for posts and projects
- Queue-ready structure for asynchronous workflows
- SEO-focused metadata support

---

## Tech Stack

**Backend**
- Laravel 13
- PHP 8.4
- Eloquent ORM
- Artisan Console Commands

**Frontend**
- Blade
- Alpine.js
- Tailwind CSS
- Vite

**Data / Infra**
- MySQL or SQLite
- Composer
- Node.js / npm

---

## What Makes This Project Stand Out

This is not a basic one-page portfolio.

It is built like a **real product**:
- structured backend models
- routed pages and APIs
- admin content management
- reusable Blade layouts/components
- database migrations and seeders
- test setup with PHPUnit
- SEO and content publishing considerations

That makes it relevant not only as a design piece, but also as a demonstration of:
- backend engineering
- full-stack thinking
- content architecture
- product presentation
- maintainable Laravel application structure

---

## Main Sections

- **Home** — landing experience with branded messaging
- **About** — concise developer profile and skills snapshot
- **Projects** — filterable portfolio case studies
- **Blog** — content publishing for technical writing or product updates
- **Testimonials** — social proof and credibility
- **Contact** — direct inquiry workflow for clients, recruiters, or collaborators
- **Admin Dashboard** — internal content management interface

---

## Project Structure

```text
portfolio/
├── app/                # Application logic, controllers, models, mail, support classes
├── bootstrap/          # Framework bootstrap files
├── config/             # Laravel configuration
├── database/           # Migrations, seeders, factories
├── public/             # Public assets and entrypoint
├── resources/          # Blade views, CSS, JS assets
├── routes/             # Web, API, and console routes
├── scripts/            # Supporting scripts (e.g. OG image generation)
├── storage/            # Uploaded/publicly served files and framework storage
├── tests/              # PHPUnit tests
├── composer.json       # PHP dependencies
├── package.json        # Frontend dependencies
└── README.md
Core Capabilities
Projects
Projects can be presented with:

title
slug
description
details
tech stack
featured status
publication date
GitHub link
live demo link
image
Blog
Blog posts support:

publishing workflow
categories
related content
individual post pages
SEO-ready structure
Contact Workflow
The site includes a portfolio-friendly contact flow:

public submission form
validation
inbox management in admin
read/unread states
reply handling
SEO & Sharing
The app is built with discoverability in mind:

/sitemap.xml
/robots.txt
metadata support
Open Graph image generation for posts/projects
API Endpoints
Example routes exposed by the application:

HTTP
GET  /api/projects
GET  /api/projects/{project}
POST /api/v1/contact
Authenticated routes also exist for protected contact/project access in admin-related flows.

Local Development
Requirements
PHP 8.4+
Composer
Node.js 18+
npm
MySQL or SQLite
Setup
bash
git clone https://github.com/Dawud-Muhammed/portfolio.git
cd portfolio

composer install
npm install

cp .env.example .env
php artisan key:generate

php artisan migrate
npm run build

php artisan serve
For development with the Vite dev server:

bash
npm run dev
Testing
Run the test suite with:

bash
php artisan test
Docker
If you add the Dockerfile, you can build and run with:

bash
docker build -t portfolio .
docker run -p 8000:8000 portfolio
Recruiter Notes
This project demonstrates:

Laravel application structure
CRUD-heavy admin features
dynamic portfolio content management
API handling
frontend polish with Alpine.js + Tailwind CSS
real-world routing, models, migrations, and UI composition
SEO-aware portfolio engineering
If you are reviewing this repository as a hiring manager, this project is intended to show both:

engineering capability
product presentation sense
Roadmap
Potential next improvements:

expand automated test coverage
add richer analytics
add image upload optimization pipeline
improve content scheduling/publishing workflows
add CI/CD validation
add multi-user admin roles/permissions
add richer case study storytelling sections per project
```

---

## Contact

- Dawud Muhammed
- GitHub: @Dawud-Muhammed
- LinkedIn:in/dawud-muhammed-811088338
- Portfolio live URL:dawud-muhammed.me
- Email:dawud2147@gmail.com
- This project is licensed under the MIT License.