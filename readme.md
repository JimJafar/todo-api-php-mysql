# A simple REST API for a TODO app

I built this for people to practice with REST API's using Angular, React etc.

Just fire up your *AMP webserver of choice and add a virtual host pointing to the */api* directory  

Use PHP MyAdmin or commandline or whatever to run the SQL in */database/schema.sql*  

Then start making any of these requests:  

Get all TODO's:  
`GET /todo`  

Gets TODO with id 42:  
`GET /todo/42`  

Add a TODO: *(don't include an id property - it will be ignored)*  
`POST /todo`  

Update TODO with id 42:  
`PUT /todo/42`  

TODO's are sent and received in JSON using the following format:

    {  
        "id": 42,  
        "name": "Buy some milk",  
        "status": "done"  
    }  