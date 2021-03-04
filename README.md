# LaraMovies 🎬
 Movie Application using the TMDb Rest API.

## Setup 🚀

- Clone the repository
  
  ```
  git clone https://github.com/vcjpierre/laravel-movies.git
  cd laravel-movies
  ``` 


- Install all dependencies

  ```
  composer install
  ```

- Rename or copy `.env.example` file to `.env`

- Set your `TMDB_TOKEN` in your `.env` file. You can get an API key [here](https://www.themoviedb.org/documentation/api). Make sure to use the ["API Read Access Token (v4 auth)"](https://www.themoviedb.org/settings/api).

- Generate key
  
  ```
  php artisan key:generate
  ```

- Start Laravel development server
 
  ```
  php artisan serve
  ```

- Go to `http://127.0.0.1:8000` in your browser.
