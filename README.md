# laravel-forum : Discussion Forum

Features:-

1. User Registration / Login
2. Guest user can also read the discussions , but cannot create any discussion
3 Authenticated user can choose the categories for the discussion and then create the discussion
4. When a new reply is added to a discussion , the owner of the discussion will be notified by email. 
5. All the notification information is storing into the database aswell. So that when a user is logged on, they can see any new notifications on the notification panel.
6. Owner of the discussion can choose the best reply. When a reply is marked as a best reply, the owner of that reply will get a notification in the mail mentioning that your
reply is marked as the best reply.
7.Authorised user can watch/unwatch the discussion will be notified by email
8. All the user inputs are validated
9. Using laravel Queue job for sending notifications, which will improve the performance of the application application significantly by allowing to delay a time-consuming
task until a later time.
