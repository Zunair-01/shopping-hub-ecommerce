# Shopping Hub

"A customer-centric e-commerce platform built to deliver a seamless and engaging online shopping experience. It allows users to browse products, add items to their cart, and securely complete purchases. The system includes order tracking, discount offers. Admins manage categories, pricing, stock levels, and customer feedback through an intuitive dashboard, ensuring smooth operation and real-time insights."

---

## 🚀 Key Features

- **Customer-Centric Shopping:** Smooth product browsing, intuitive shopping cart, and quick checkout flow.
- **Order Tracking & Status Updates:** Real-time visibility into order processing and delivery status.
- **Discounts & Promotions:** Dynamic voucher and coupon system for promotional offers.
- **Admin Management Dashboard:** Complete control over product categories, stock inventory, pricing, and user reviews.
- **Secure Payment Integration:** Integrated Stripe API for fast and reliable card payment processing.

---

## 🛠️ Tech Stack

- **Backend:** Laravel / PHP
- **Database:** MySQL
- **Payment Gateway:** Stripe API
- **Frontend:** HTML5, CSS3, Bootstrap, JavaScript, Ajax
- **Templating Engine:** Laravel Blade

---

## 💻 Local Setup Instructions

Follow these step-by-step instructions to set up and run the project in your local development environment:

### 1. **Clone the Repository**
Clone the project repository to your local machine and navigate into the project directory:

```bash
git clone [https://github.com/Zunair-01/shopping-hub-ecommerce.git](https://github.com/Zunair-01/shopping-hub-ecommerce.git)
cd shopping-hub-ecommerce

```

### 2. **Install PHP Dependencies**

Install all required Composer packages and backend dependencies:

```bash
composer install

```

### 3. **Configure Environment File**

Create a copy of the default environment configuration file:

```bash
# On Windows (CMD / PowerShell):
copy .env.example .env

# On Linux / macOS / Git Bash:
cp .env.example .env

```

### 4. **Generate Application Key**

Generate the Laravel security and encryption key:

```bash
php artisan key:generate

```

### 5. **Configure Database & Credentials**

Start your local MySQL server (via XAMPP, WAMP, or terminal), create a database named `shopping_hub_db`, and update the `.env` file:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=shopping_hub_db
DB_USERNAME=root
DB_PASSWORD=

# Stripe Payment Gateway Credentials
STRIPE_KEY=your_stripe_publishable_key
STRIPE_SECRET=your_stripe_secret_key

```

### 6. **Run Database Migrations & Seeders**

Set up the database tables and populate default sample data:

```bash
php artisan migrate --seed

```

### 7. **Link Storage Directory**

Create the symbolic link to make uploaded product images and assets publicly accessible:

```bash
php artisan storage:link

```

### 8. **Start the Application**

Launch the Laravel local development server:

```bash
php artisan serve

```

Access the application in your browser at: **`http://127.0.0.1:8000`**

