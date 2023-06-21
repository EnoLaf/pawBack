# pawBack

This project contains the backend implementation for the PAW project using PHP Symfony framework. The PAW project aims to digitize the pet's health record. It includes several features such as user and animal CRUD operations, adding documents, and accessing medical data for the animals.

## Features

- User management: Create, read, update, and delete user accounts.
- Animal management: Perform CRUD operations for managing animal records.
- Document upload: Allow users to upload documents related to their pets.
- Access medical data: Provide access to the medical history and records of the animals.
- Authentication and authorization: Implement user authentication and authorization to secure the application.
- Data validation and sanitization: Validate and sanitize user inputs to ensure data integrity and security.
- Database interactions: Use Symfony's Doctrine ORM for seamless database interactions.

## Technologies Used

The backend of the PAW project is built using the following technologies:

- **PHP**: A popular server-side scripting language.
- **Symfony**: A PHP framework that provides a robust set of tools and libraries for web development.
- **Doctrine ORM**: An object-relational mapping tool for efficient database interactions.
- **MySQL**: A widely used relational database management system.
- **RESTful APIs**: Building and consuming RESTful APIs to communicate with the frontend or external services.

## Installation

To set up the PAW project backend locally, follow these steps:

1. Ensure that PHP and Composer are installed on your machine.
2. Clone this GitHub repository to your local environment.
3. Navigate to the project directory using your terminal.
4. Run **`composer install`** to install the project dependencies.
5. Configure the database connection in the .env file.
6. Run the database migrations using the command **`php bin/console doctrine:migrations:migrate`**.
7. Start the development server with **`php -S localhost:8000 -t public`**.

Ensure that you set appropriate permissions and secure sensitive information such as database credentials.

## Usage

Once the backend is up and running, you can interact with the API endpoints using tools like Postman or by integrating with the corresponding frontend application. Refer to the API documentation for details on available endpoints and request/response formats.

## License

This project is licensed under the MIT License. You can refer to the [LICENSE](LICENSE) file for more information.

## Author

This project was created by Enora Lafforgue ([enora.lafforgue@gmail.com](mailto:enora.lafforgue@gmail.com)). Feel free to contact me if you have any questions or comments.
