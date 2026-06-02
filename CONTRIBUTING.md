# Contributing to WVSU: ReClaim

First off, thanks for taking the time to contribute!

All types of contributions are encouraged and valued. Please make sure to read the relevant section before 
making your contribution. It will make it a lot easier for us maintainers and smooth out the experience
for all involved. The community looks forward to your contribution.

## Project Repo

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
- Please read the official CITE Development Guide for Git workflow and development standards:

   👉 https://github.com/USC-CITE/development-guides/blob/main/cite-git-workflow.md


## Your First Code Contribution

1. Fork the repository
2. Clone your fork
3. Additional Setup Files
   Some required development files are not currently included in the repository. Before running the project, download and place the following files/folders in the project root directory:
- `php.ini`
- `apache2/`
- `mysql/`

   Download them here:
   https://drive.google.com/drive/folders/1OMmJvei1bpF5yXvun5yII0-fJpOr_9WU?usp=sharing
4. Create a branch:<br>
`git checkout -b [category]/[issue-reference]/[description]`<br>
5. Build and run the application using Docker:<br>
`docker compose up --build -d`<br><br>
To restart existing containers:<br>
   `docker compose start`<br><br>
   To stop containers:<br>
   `docker compose stop`<br><br>
   To view logs:<br>
   `docker compose logs -f`<br>
6. Install Dependencies and Build Assets:
Once your containers are running, you need to initialize your backend packages and compile your frontend assets. <br>
Run the following commands:
**PHP Dependencies (Composer)**
   `docker compose exec reclaim-server composer install`
**Node Modules**
    `docker compose exec reclaim-server npm install`
**Tailwind CSS**
   `docker compose exec reclaim-server npm run build  `

7. Make changes
8. Test locally
9. Commit changes
10. Push branch
11. Open a Pull Request


## Style Guides
- Follow existing project structure
- Use prepared statements for database queries
- Validate all user inputs
- Keep code readable and modular


## Attribution

This guide is adapted from open-source contributing best practices, including https://contributing.md/, and tailored for the WVSU: Re-Claim project under WVSU - SPARK Hub in collaboration with USC-CITE.

Special thanks to the contributors and the CITE Development Guides for workflow standards:
https://github.com/USC-CITE/development-guides