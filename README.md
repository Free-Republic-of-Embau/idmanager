# Governamental Citizen ID Bank v1.0

Official project of the **Free Republic of Embaú** for managing Citizen Identifications (ID). This tool is available for any micronation interested in adopting an efficient digital system for ID registration and control.

## Features

- **Create ID**: Allows generating a unique ID number for each registered citizen.
- **Check ID**: System to verify the authenticity and data of an ID.
- **Government Employee Login Only**: Only authorized government employees can access the administrative panel.
- **Government Notes**: A system to record official notes and communications linked to each citizen's ID.
- **ID Block/Unblock**: Tool to block IDs, useful for citizens considered criminals or with restrictions, and to restore the ID's status when necessary.
- **Pre-built Security**: The system includes security measures to prevent **XSS (Cross-Site Scripting) attacks** and sanitize inputs, ensuring safer operations.

## Requirements

To host the **Governamental Citizen ID Bank**, it is recommended to use:

- **WAMP** (Windows, Apache, MySQL, PHP) or 
- **XAMPP** (Cross-Platform, Apache, MariaDB, PHP, Perl).

### Installation

1. Download or clone the repository.
2. Place the files in the `www` directory (or equivalent) of your local server.
3. Access `localhost/install.php` through the browser to start the installation.
4. Follow the on-screen instructions to set up the database and complete the installation.

## Usage and Responsibility

This project is **available to all micronations**. However, responsibility for the use, modification, and control of the system's functions is **entirely up to the end user**. We, the Free Republic of Embaú, do not take any responsibility for actions resulting from the use of this system.

## License

This software is distributed "as is", without warranties or liabilities. It is free to use, but it is expected that governments using it will do so ethically and responsibly.

## Security

The **Governamental Citizen ID Bank** has pre-configured security measures, including:

- **XSS Protection**: Cross-Site Scripting attacks are mitigated through the sanitization of user inputs and proper encoding of outputs.
- **Sanitization**: All inputs are sanitized to ensure that no malicious code can be injected into the system.

## Contact

For questions or contributions, contact the government of the Free Republic of Embaú through official channels.

