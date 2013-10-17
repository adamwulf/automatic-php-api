# Automatic API

This is an unofficial PHP API for the Automatic Link (http://www.automatic.com/). The Automatic Link plugs into your car's data port and connects to your phone to help you track and improve your driving habits. This API gives you access to the data stored in your Automatic account, including your car information, driving history, parked locations, and profile information.

Since Automatic isn't planning on prioritizing an offical API or data export anytime soon (http://community.automatic.com/automatic/topics/export_or_download_data_history), I've decided to try and build it myself to download my data from Automatic. This is what I've got so far, suggestions welcome!

# API Credentials

The API requires a username and password to access your data. However - the username and password for the API is different than the username and password that you use to access the site or login to the iPhone app.

To find the username and password to use for the API, we'll need to proxy your iPhone's HTTP traffic through your computer so that we can watch the API calls from the phone and use the same username and password that the phone uses. Instructions for finding your API username and password can be found in the wiki at https://github.com/adamwulf/automatic-php-api/wiki
