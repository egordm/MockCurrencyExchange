# Centralized Exchange Concept
We have build a fully functional centralized exchange. The frontend is using React and the backend is powered by Laravel.

## [View demo](https://www.youtube.com/watch?v=9VbuzYH5QEA)

## Discalimer
This project is built for educational reasons and is not meant to use in real world scenario. Please use it at your own risk. We are not responsible for any damages or problems that may arise.

## Features
* Registration, login and balance management
* Multi currency trading (Market order and Limit order)
* Best buyer seller matching
* Beautiful trading ui
* Different market indicators and tools like trendline and fibonacci retracement
* Muliple different intervals for the stock chart
* Depth Chart
* Order history and portfolio

## Future improvements
* Switch from polling for changes to a websocket information retrieval for the charts.
 
## [API Documentation](https://documenter.getpostman.com/view/325304/onemil/7ELbBHB)

## Usage
### Backend
Basically set it up als a laravel project and it will work. Dont forget to migrate the data to the database.

You also want to fill in binance api credentials for the live market data in the `.env`.

### Frontend
Use webpack to compile the frontend sass and js.

## Acknowledgements
Frontend is hugely inspired by binance ui
