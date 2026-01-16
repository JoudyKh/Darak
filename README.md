Darak Real Estate Platform 🏠

Darak is a modern, full-featured Real Estate Management System built with the Laravel framework. The platform provides a seamless experience for users to list, search, and manage properties, while offering administrators a robust dashboard for oversight and management.

✨ Key Features

Property Listings: Comprehensive system for adding, editing, and displaying real estate properties with detailed specifications.

Advanced Search & Filtering: Users can filter properties based on location, price range, type (Sale/Rent), and specific amenities.

Admin Dashboard: A centralized management interface for monitoring listings, users, and platform statistics.

Multimedia Support: Robust handling of property images and galleries to provide a visual experience for potential buyers.

User Authentication: Secure login and registration system for both property seekers and agents.

Responsive Design: Optimized for a seamless experience across desktops, tablets, and mobile devices.

🛠 Technical Stack

Backend: Laravel 10.x

Database: MySQL

Frontend: Blade Templates, Bootstrap / Tailwind CSS

Authentication: Laravel Breeze / Fortify (standard secure auth).

Architecture: MVC (Model-View-Controller).

🚀 Installation & Setup

Follow these steps to set up the project locally:

Clone the Repository:

git clone [https://github.com/JoudyKh/Darak.git](https://github.com/JoudyKh/Darak.git)
cd Darak


Install Composer Dependencies:

composer install


Install Frontend Assets:

npm install && npm run dev


Environment Setup:

Copy .env.example to .env.

Configure your database settings in the .env file.

php artisan key:generate


Database Migration:

php artisan migrate --seed


Serve the Application:

php artisan serve


📂 Project Highlights

Eloquent ORM: Leverages Laravel's ORM for efficient database querying and relationship management (e.g., Property belongs to Category).

Form Validation: Strict server-side validation to ensure data integrity for property submissions.

Storage Integration: Uses Laravel's File Storage system for efficient image management.

👩‍💻 Developer

Joudy Alkhatib

GitHub: @JoudyKh

LinkedIn: Joudy Alkhatib

Email: joudyalkhatib38@gmail.com

Darak - Redefining the Real Estate Search Experience.
