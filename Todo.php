<?php

/*



                                                         DONE
----------------------------------------------------------------------------------------------------------------
 TODO: add functionality to remember me for the login
  
    -If the user successfully logs in with remember me checked create a login cookie
    -the login cookie will contain the Username, and 2 random tokens using {  random_bytes(32);  } to generate
    -store this username and the tokens (series and token) into the database so it can be compared to when the user comes back if
      the cookie is present.
    -If the username and tokens are equal to the database then the user is considered authenticated and they receive
      a new token (not series)
  
    -If the username and series match but the token doesn't then a theft is assumed. Display a warning about the theft
      and delete all of the user's remembered sessions
    -If the username and series is not present then ignore the cookie
 TODO: implement hashing to sensitive information\

     - possible password salt
     -don't allow spaces in passwords
  
 TODO: Separate register() function from AuthController class and move it to a registrationController class
 
 
 
 
 
 
 
                                                     In-Progress
 ----------------------------------------------------------------------------------------------------------------
   TODO: add database error handling
   TODO: fix database connects and how I connect
   TODO: move server connection info to a separate config page
   TODO: Add Docker to the project
   TODO: finish implementing discount codes



 
 
 
 
 
 
 
 
 
                                                        Remaining
 ----------------------------------------------------------------------------------------------------------------
  TODO: implement redis for data caching in memory

  TODO: implement compiled routing
  
  
  
  
  TODO: implement password resetting
  
  
  
  
  TODO: fix navBar, login page and registration page
  
  

  
  TODO: implement purchased database in order to save the purchase
  
  
  TODO: possibly implement payment section but numbers don't matter
  
    -MAKE SURE TO PUT DISCLAIMER THAT REAL CARD SHOULDN"T BE USED SINCE NOTHING WILL ACTUALLY BE BOUGHT
  
  
  TODO: implement save for later
  
  
  TODO: implement profile page
  
     -delete profile
     -change username (only allow once every 30 days)
     -change password
     -add payment method
     -add a membership level ... exclusive store items and free expedited shipping
     -track live orders ... just add a date that the item will expire and once it expires move it
      from tracking to past purchases
     -view past purchases
     -view saved for later items
     -save address
  
  


  
  
  */
