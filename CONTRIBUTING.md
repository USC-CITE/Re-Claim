# Contributing to WVSU: ReClaim

First off, thanks for taking the time to contribute!

All types of contributions are encouraged and valued. Please make sure to read the relevant section before 
making your contribution. It will make it a lot easier for us maintainers and smooth out the experience
for all involved. The community looks forward to your contribution.

## Table of Contents

- [Code of Conduct](#code-of-conduct)
- [I have a Question](#i-have-a-question)
- [Development Guides](#development-guides)
- [Your First Code Contribution](#your-first-code-contribution)
- [Style Guides](#style-guides)
- [Attribution](#attribution)

## Code of Conduct

This project and everyone participating in it is governed by a respectful and inclusive environment. By participating,
you are expected to act professionally and respectfully toward others. If you encounter unacceptable behavior, please report via Github Issues.


## I Have A Question
Before asking a question, please:
- Search existing [Issue](/issues)
- Check the documentation and README

If you still need help:
- Open a [Github Issue](/issues/new)
- Provide as much context as possible
- Include relevant environment details (PHP version, browser, OS, etc)


## Development Guides
👉 Please read the [official CITE Development Guide](https://github.com/USC-CITE/development-guides/blob/main/cite-git-workflow.md) for Git workflow and development standards:

## Your First Code Contribution

1. Fork the repository
2. Clone your fork
3. Rename `.env.example` to `.env`
4. Some required development files are not currently included in the repository. Before running the project, [download](https://drive.google.com/drive/folders/1OMmJvei1bpF5yXvun5yII0-fJpOr_9WU?usp=sharing) and place the following files/folders in the project root directory.
- `php.ini`
- `apache2/`
- `mysql/`
- `dev_reclaim_app.sql`
5. Create a branch:<br>
`git checkout -b [category]/[issue-reference]/[description]`<br>
6. Build and run the application using Docker:<br>
`docker compose up --build -d`<br>
To restart existing containers:<br>
   `docker compose start`<br>
   To stop containers:<br>
   `docker compose stop`<br>
   To view logs:<br>
   `docker compose logs -f`<br>
7. Import `dev_reclaim_app.sql` to your MySQL database and create your custom user with password via a database client [(DB Visualizer)](https://www.dbvis.com/) or the command line
8. Once your containers are running, you need to initialize your backend packages and compile your frontend assets.
Run the following commands:<br>
**PHP Dependencies (Composer)**
   `composer install`<br>
**Node Modules**
    `npm install`<br>
**Tailwind CSS**
   `npm run build  `

9. Make changes
10. Test locally
11. Commit changes
12. Push branch
13. Open a Pull Request


## Style Guides
- Follow existing project structure
- Use prepared statements for database queries
- Validate all user inputs
- Keep code readable and modular


## Attribution

This guide is adapted from open-source contributing best practices, including https://contributing.md/, and tailored for the WVSU: Re-Claim project under WVSU - SPARK Hub in collaboration with USC-CITE.

Special thanks to the contributors and the CITE Development Guides for workflow standards:
https://github.com/USC-CITE/development-guides