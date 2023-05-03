+id : int primary key
+email: varchar(100)
+fullname: varchar(50)
+phone: varchar(20)
+password: varchar(50)
+forgotToken : varchar(50)
+activeToken: varchar(50)
+status: tinyint
+createdAt
+updatedAt

-Bảng loginToken
+id: int primary key
+userID: int forrign key đến users(id)
+token : varchar(50)

gg token: yrsuqrxqhmjkeqmb