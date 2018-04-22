# PHP-Creations
This repo is for all current and future projects i will have done using PHP

# Repo Contains
- CLI Application: GitHub Vulnerable Code Searcher



# GitHub Vulnerable Code Searcher
1. How to use
2. Known Issues

**How to use:**
- Start your web server
- Add your GitHub credentials to the `$user` and `$pwd` variables in the `index.php` file 
- Open `SearchTerms.txt` and populate it. **1 QUERY PER LINE - NO MORE THAN 5 QUERIES OTHERWISE THE SCRIPT IS RATHER SLOW**  
- Open your shell  and execute the script like so `php index.php -l <language> -p <number of desired results> > output.php` to produce the script results
- Open your browser and navigate to the new output file like you would a website

**Known Issues:**
- As a CLI Application, the `Line Number` field yields warnings and breaks some areas of the code - **FIXED**
- As a CLI Applicatrion,  the format of the output script breaks

**Notice:**
- Pagination feature was worked on at one point, decided to remove it as it just makes the script take far too long
- This project was a learning experience, and as such the code is messy. Hence, I Have decided to recode this project using an already existing API Library - [https://github.com/KnpLabs/php-github-api].
- New version of this project is coming soon
