
**WORK IN PROGRESS**

SoleVault is a full-stack e-commerce website dedicated to the sale of shoes. The project utilizes a vanilla PHP backend with the MVC architecture and leverages Apache as the web server. MySQL is employed for efficient database management. On the frontend, JavaScript, CSS, and Bootstrap are used to enhance the user interface and deliver an engaging experience. Additionally, AJAX calls are incorporated, for example in the Cart feature, allowing real-time updates to the UI without the need for page refreshes.

## Features

- Browse and search for a wide range of shoes.
- Add items to the shopping cart.
- View and modify the shopping cart.
- Proceed to the checkout process.
- Manage user accounts and login/logout functionality.
- Real-time updates to the UI with AJAX calls.
- Remember Me functionality with token and series
- Warning is displayed if token and series get stolen and used elsewhere upon visiting the site again
- Proper password hashing for security  

## Installation

To run this project locally, follow these steps:

1. Make sure you have Apache, PHP, and MySQL installed on your machine.
2. Clone this repository: `git clone https://github.com/your-username/solevault.git`.
3. Place the cloned repository inside the `htdocs` directory of your Apache installation.
4. Navigate to the project directory: `cd solevault`.
5. Run the `dbCreationScript.sql` file located in `app/model/sql` on your database console to create the necessary database schema.
6. Configure the database connection in the `Database.php` file located in `app/model`. Modify the constructor with your database credentials.
7. Start your local Apache server.
8. Open your browser and visit `http://localhost/solevault`.

## Contributing

Contributions are welcome! If you have any suggestions, bug reports, or feature requests, please open an issue on the GitHub repository. If you would like to contribute directly to the project, you can fork the repository, make your changes, and submit a pull request.

## License

This project is licensed under the MIT License. See the [LICENSE](LICENSE) file for more information.

## Contact

If you have any questions or need assistance, feel free to contact me at [luccasgraterol1984outlook.com](mailto:luccasgraterol1984outlook.com).

Please note that this project is still a work in progress, and further enhancements and improvements are planned.
