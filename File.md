File
1. authentication system
   register/login/forget password
2. Category crud
3. Product crud  
4. Order processing module
5. Customer account
6. Track Order
7. CMS{Homepage, Staticpages, Banner}

-----------------------------------------------

Database Tables
1. User: id, name, email, password, phone number, status
2. Category: uid, title, slug, status
3. Product: uid, title, slug, image, description, price, discount, category id, status
4. Order: uid, user id, total, total discout, status, tracking id
5. Order item: order id, product id, price, discount
6. Page: id, title, slug, content, status
7. Section: id, title, content, status, order no
8. Billing: id, user id, address, city, state, country, zipcode
