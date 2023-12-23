Users can signup and login.

Users can create blog posts, which other users including the author can comment on.
These blog posts must be categorized. These posts can also have many tags. 


Models needed:
    -- User
    -- BlogPost
    -- Comment
    -- Tag
    -- Categories


Things to do today:

    <!-- -- Implement user signup -->
    <!-- -- Implement authentication -->
    <!-- -- Make use of middlewares to protect routes -->


Create custom requests for every model
    Tag
    Like
    User
    Comment
    Blogpost
    Category

Test to check if CRUD operations are still working
Implement gates and policies to prevent just about any user from updating existing records
Create a group model
Create a group join request model
Apply gates and policies in groups
