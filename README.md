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
        * roles
        * permissions
    
    * Group columns:
        ** id
        ** Name

    * Columns
        -- group_join_request
            --- id (bigint)
            --- requester_id (bigint)
            --- group_id (bigint)
            --- is_approved (bool)

        -- group_members
            --- id (bigint)
            --- user_id (bigint)
            --- group_id (bigint)
            --- is_admin (boolean)


    ** Business logic
        ** group
            **** POST
                **** The logged in user will immediately become admin on create
                **** The admin will be added as a user in the group_members with the is_admin set to true

            *** GET
                **** Users should be able to see a list of groups they are a member of
                **** Users who are admins should also be able to see what groups they own and administrate

            **** PUT
                **** Group name change can only be done by the admin

            **** DELETE
                **** Group delete will remove all members of this group from this group (Only the admin is allowed to do this)

        *** group_join_request
            *** GET
                **** Group specific:
                    ***** Only the admin user can see the pending requests of his group/(s)
                **** User specific:
                    ***** The user should be able to see all groups he has asked to join

            **** POST
                **** Create a record that stores the group and the requester_id 
                **** Default `is_approved` false column in that record 
                **** The admin of the group in question should not be able to join his own group

            **** PUT
                *** Only the admin can approve requests

            **** DELETE
                **** Only the user who made the request and the group admin can delete group_join_requests

