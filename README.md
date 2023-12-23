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


# Groups
    * Groups must have a single admin, which will initially be the user who creates that group
    * Users can join groups by creating join requests that only the admin can approve
    * Users can only join that particular group when the admin has approved of it


    * Models
        * groups
        * group_join_requests
        * group_members
    
    * Group columns:
        ** id
        ** Name

    * group_join_request columns:
        ** id (bigint)
        ** requester_id (bigint)
        ** group_id (bigint)
        ** is_approved (bool)

    * group_members columns:
        ** id (bigint)
        ** user_id (bigint)
        ** group_id (bigint)
