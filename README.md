# Restaurant website

# KŌI — Japanese Dining

> **Japanese dining, reimagined.**

KŌI is a modern sushi restaurant website concept focused on combining traditional Japanese cuisine with a luxurious, minimalist digital experience.

The website is designed to feel elegant, calm and premium while keeping the user experience simple and intuitive.

---

## ✨ Features

* 🍣 Modern sushi restaurant menu
* 🥢 Signature dishes and sushi collections
* 📖 Restaurant information
* 📅 Table reservation system
* 📱 Responsive design
* ✨ Smooth animations and interactions
* 🛒 Online ordering *(if implemented)*
* 🔐 Admin dashboard *(if implemented)*
* 🗄️ Database integration *(if implemented)*

---

## 🎨 Design

The design combines **modern Japanese aesthetics** with a high-end restaurant feel.

### Color palette

| Color          | Hex       |
| -------------- | --------- |
| Charcoal Black | `#0D0D0D` |
| Warm White     | `#F4F0E8` |
| Sage Olive     | `#7A8065` |
| Dark Brown     | `#241F1A` |

The website uses large food photography, generous spacing, subtle animations and a minimal interface to create a premium atmosphere.

### Typography

* **Headings:** Elegant serif
* **Body:** Modern sans-serif
* **Logo:** Custom typographic treatment of `KŌI`

---

## 🖥️ Pages

### Home

The main landing page introducing KŌI, its concept and signature dishes.

### Menu

A complete overview of the restaurant's sushi, sashimi, rolls and other dishes.

### About

Information about the restaurant, its philosophy and approach to Japanese cuisine.

### Experience

A closer look at the dining experience at KŌI.

### Reservations

A reservation form where customers can book a table.

### Contact

Restaurant location, opening hours and contact information.

---

## 🛠️ Technologies

This project is built using:

* HTML5
* CSS3
* JavaScript
* PHP
* MySQL

Additional libraries and tools:

* [Add your libraries here]
* [Add frameworks here]
* [Add APIs here]

---

## 📂 Project Structure

```text
Koi/
│
├── assets/
│   ├── images/
│   ├── icons/
│   └── fonts/
│
├── css/
│   └── style.css
│
├── js/
│   └── script.js
│
├── php/
│   └── ...
│
├── pages/
│   ├── index.php
│   ├── menu.php
│   ├── about.php
│   ├── experience.php
│   ├── reservation.php
│   └── contact.php
│
├── database/
│   └── database.sql
│
└── README.md
```

> Update the structure above to match the actual project structure.

---

## 🗄️ Database

The website can use a MySQL database to store information such as:

* Menu items
* Categories
* Reservations
* Customer information
* Users/admins

Example database structure:

```text
users
├── id
├── name
├── email
└── password

menu_items
├── id
├── name
├── description
├── price
├── category_id
└── image

reservations
├── id
├── name
├── email
├── date
├── time
└── guests
```

---

## 🚀 Installation

### 1. Clone the repository

```bash
git clone https://github.com/yourusername/koi.git
```

### 2. Move the project

Place the project inside your local server directory, for example:

```text
xampp/htdocs/koi
```

### 3. Create the database

Create a MySQL database and import:

```text
database/database.sql
```

### 4. Configure the database

Update the database connection settings in the project's configuration file.

### 5. Start the server

Start:

* Apache
* MySQL

Then open:

```text
http://localhost/koi
```

---

## 🎯 Project Goals

The main goal of KŌI is to create a professional restaurant website that demonstrates both **front-end design** and **back-end development** skills.

The project focuses on:

* Responsive web design
* Clean and maintainable code
* PHP backend development
* Database management
* User interaction
* Form validation
* CRUD functionality
* Creating a realistic business website

---

## 📸 Screenshots

### Homepage

*Add screenshot here*

### Menu

*Add screenshot here*

### Reservation

*Add screenshot here*

---

## 🔮 Future Improvements

Possible future additions include:

* [ ] Online payment system
* [ ] Customer accounts
* [ ] Admin dashboard
* [ ] Reservation management
* [ ] Online ordering
* [ ] Order tracking
* [ ] Email confirmation
* [ ] Japanese/English language switch
* [ ] Dark/light theme
* [ ] Customer reviews

---

## 👩‍💻 Author

**Ava**

MBO Webdevelopment — Level 4

This project was created as a webdevelopment portfolio/project piece.

---

## 📄 License

This project was created for educational and portfolio purposes.


┌─────────────────────────────────┐
│ KŌI     MENU ABOUT EXPERIENCE   │
│                         RESERVE │
├─────────────────────────────────┤
│                                 │
│             KŌI                 │
│   Japanese dining, reimagined.  │
│                                 │
│       [ VIEW MENU ]             │
│                                 │
├─────────────────────────────────┤
│          OUR MENU               │
│                                 │
│  Sushi     Sashimi     Rolls     │
│                                 │
├─────────────────────────────────┤
│                                 │
│       A TASTE OF JAPAN          │
│       About the restaurant      │
│                                 │
├─────────────────────────────────┤
│                                 │
│       THE KŌI EXPERIENCE        │
│                                 │
├─────────────────────────────────┤
│                                 │
│       RESERVE A TABLE           │
│       [ reservation form ]      │
│                                 │
├─────────────────────────────────┤
│          CONTACT                │
│     Opening hours / location    │
└─────────────────────────────────┘

KŌI
│
├── Frontend
│   ├── Hero
│   ├── Menu
│   ├── About
│   ├── Experience
│   └── Contact
│
└── Backend
    ├── Database
    ├── Menu management
    ├── Reservations
    ├── Admin login
    └── Reservation management