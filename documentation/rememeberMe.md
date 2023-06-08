# Remember Me Functionality Documentation

This document provides an overview of the implementation details for the Remember Me functionality within our application.

## Overview

The Remember Me functionality allows users to stay logged in even after closing and reopening the application. When the 
user successfully logs in with the "Remember Me" option checked, a `login cookie` is created. This `login cookie` contains 
the username and two randomly generated `tokens`. The `username` and `tokens` (`series` and `token`) are stored in the database 
for verification when the user returns.

## Implementation Steps

1. **Creating the Login Cookie:**
    - When a user logs in with the "Remember Me" option checked, a login cookie is created.
    - The login cookie contains the following information:
        - `Username`: The username of the authenticated user.
        - `Token`: Two randomly generated tokens using the `random_bytes(32)` function.

2. **Storing Information in the Database:**
    - The `username`, `series`, and `token` values from the `login cookie` are stored in the database.
    - This information is stored so that it can be compared to the `login cookie` when the user returns.

3. **Authentication Process:**
    - When a user visits the site and presents a `login cookie`:
        - Retrieve the `username`, `series`, and `token` values from the `cookie`.
        - Compare these values with the corresponding entries in the database.
        - If the `username` and `tokens` match the database records, the user is considered `authenticated`.
        - Generate a `new token` (not series) for the user.

4. **Handling Unauthorized Access or Theft:**
    - If the `username` and `series` match but the token does not match, it indicates a potential theft or unauthorized access.
    - In this case:
        - Display a warning to the `user` about the potential theft.
        - Delete all the user's `remembered sessions` from the database.

5. **Ignoring Invalid or Missing Data:**
    - If the `username` and `series` are not present in the database or do not match, the `login cookie` is ignored.
    - The user is treated as `unauthenticated`, and they need to log in again.

## Conclusion

The Remember Me functionality implementation allows users to stay logged in using a login cookie with randomly generated
tokens. By storing and comparing these tokens in the database, we can authenticate users and detect potential theft or
unauthorized access. The system provides a secure and convenient experience for users who choose to utilize the Remember
Me feature.