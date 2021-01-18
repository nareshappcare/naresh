This is my Mysql query .please find the mongodb query .mongodb documebts.


SELECT u.id,u.user_id,u.fullname,u.profile_pic,u.email, MAX(c.id) as ids FROM chat_history c INNER JOIN users u ON (u.user_id = c.to_id OR u.user_id = c.from_id) WHERE (c.to_id ='$uid' OR c.from_id = '$uid') AND u.user_id !='$uid'  GROUP BY u.user_id ORDER BY ids DESC



above query converted to MongoDB query. i tried the below mongodb query.


$resultData =$this->mongo_db->aggregate('users',[

                  ['$lookup' => [ 
                      'from' => 'chat_history',  
                      'localField' => 'user_id',
                      'foreignField'  =>  'to_id',
                     'foreignField'  =>  'from_id',
                      'as'  => 'chat_history',
                   ],],
                   ['$unwind'=> '$chat_history'],

                  [
                    '$match'=> [
                    '$or'=> [
                        ['chat_history.to_id'=> $uid], 
                        ['chat_history.from_id'=> $uid]
                    ],
                      '$or'=> [
                        ['chat_history.to_id'=> $uid], 
                        ['chat_history.from_id'=> $uid]
                    ],

                 ],
                

    
               ],
                ['$group' => ['_id'=>'$_id',
                'fullname' => [ '$first'=> '$fullname'], 
                'profile_pic' => [ '$first'=> '$profile_pic'], 
                'user_id' => [ '$first'=> '$user_id'], 
                'read_count' => [ '$first'=> '$read_count'], 
                'chat' => [ '$first'=> '$chat'], 
                'n_count' => [ '$first'=> '$n_count'], 
                'description' => ['$first'=> '$chat_history.description'], 
                 'create_at' => ['$first'=> '$chat_history.create_at'], 
                'from_id' => [ '$first'=> '$chat_history.from_id'],
                'to_id' => [ '$first'=> '$chat_history.to_id'],

                ],
     
            ],

            ['$project'=> [
        '_id'=> '$_id',
        'fullname'=> '$fullname',
        'profile_pic'=> '$profile_pic',
        'user_id'=> '$user_id',
        'read_count'=> '$read_count',
        'chat'=> '$chat',
        'n_count'=> '$n_count',
        'description'=> '$description',
        'create_at'=> '$create_at', 
        'from_id'=> '$from_id', 
        'to_id'=> '$to_id', 
       
    ]],

 ['$sort' => [ 'chat_history.create_at' => -1,'chat_history._id' => -1] ]
                

],[
    "cursor"=> [ "batchSize"=> 0 ]
]

);


My schema 

users:



	"_id" : ObjectId("6000387f8bb6cc1c0d1143d2"),
	"country" : "Germany",
	"deviceid" : "",
	"devicetoken" : "2TaugVH8C49TG5GaoC0jZIXnVwoCC_d0-_vFu1AQUBmfCaGAmuw9N7yeXzNLcyg_",
	"devicetype" : "android",
	"dob" : "1/1/1985",
	"email" : "",
	"gender" : "Male",
	"mobile" : "",
	"fullname" : "harivasu",
	"password" : "",
	"username" : "harivasuro86",
	"user_id" : "210114055639",
	"account_status" : "Active",
	"profile_pic" : "",
	"cd" : "2021-01-14 05:56:39"


    Chat history:


	"_id" : ObjectId("5fff22258bb6cc7679605063"),
	"from_id" : "210111034305",
	"to_id" : "210104022920",
	"description" : "Hello 👋",
	"create_at" : "2021-01-13 10:09:01",
	"image" : "",
	"read_count" : "0",
	"chat" : "0",
	"n_count" : "0"
  
  
  
  
  
