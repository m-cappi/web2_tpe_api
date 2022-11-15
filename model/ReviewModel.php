<?php

require_once('../model/Model.php');

Class ReviewModel extends Model{
    public function __construct()
    {
        parent::__construct();
        $this->db=getDataBase();
        $this->tableName='reviews';
    }

    // SELECT R.*, CONCAT(B.title) as `book`, CONCAT(A.last_name, ', ',A.name) as `author`, U.alias as `userAlias` 
    // FROM `reviews` AS R INNER JOIN `books` AS B ON R.bookId = B.id 
    // INNER JOIN `authors` as A ON B.FK_author_id = A.id 
    // LEFT JOIN `users` AS U ON R.userId = U.id 
    // WHERE R.bookId = 1 AND U.alias LIKE '%co%'
    // LIMIT 1 OFFSET 0

    public function listByBookIdSortedByFilteredBy($bookId, $sortCriteria, $sortDirection, $amount, $offset, $filterCriteria, $filterValue){
        $query = $this->db->prepare("SELECT R.*, 
        B.title as `bookTile`, 
        A.name as `authorName`, 
        A.last_name as `authorLastName`, 
        U.alias as `userAlias` 
        FROM `$this->tableName` AS R 
        INNER JOIN `books` AS B 
            ON R.bookId = B.id 
        INNER JOIN `authors` as A 
            ON B.FK_author_id = A.id 
        LEFT JOIN `users` AS U 
            ON R.userId = U.id 
        WHERE R.bookId = :bookId 
            AND :filterCriteria LIKE :filterValue
        ORDER BY :sortDirection :sortCriteria 
        LIMIT :amount OFFSET :offset"
        );
        $query->bindParam('bookId', $bookId);
        $query->bindParam('filterCriteria', $filterCriteria, PDO::PARAM_STMT);
        $query->bindParam('filterValue', $filterValue);
        $query->bindParam('sortDirection', $sortDirection);
        $query->bindParam('sortCriteria', $sortCriteria);
        $query->bindParam('amount', $amount, PDO::PARAM_INT);
        $query->bindParam('offset', $offset, PDO::PARAM_INT);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    public function listByBookIdSortedBy($bookId, $sortCriteria, $sortDirection, $amount, $offset){
        $query = $this->db->prepare("SELECT R.*, 
        B.title as `bookTile`, 
        A.name as `authorName`, 
        A.last_name as `authorLastName`, 
        U.alias as `userAlias` 
        FROM `$this->tableName` AS R 
        INNER JOIN `books` AS B 
            ON R.bookId = B.id 
        INNER JOIN `authors` as A 
            ON B.FK_author_id = A.id 
        LEFT JOIN `users` AS U 
            ON R.userId = U.id 
        WHERE R.bookId = :bookId 
        ORDER BY :sortDirection :sortCriteria 
        LIMIT :amount OFFSET :offset"
        );
        $query->bindParam('bookId', $bookId);
        $query->bindParam('sortDirection', $sortDirection);
        $query->bindParam('sortCriteria', $sortCriteria);
        $query->bindParam('amount', $amount, PDO::PARAM_INT);
        $query->bindParam('offset', $offset, PDO::PARAM_INT);
        $query->execute(); 
        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    public function addOne($comment, $rating, $bookId, $userId){
        $query = $this->db->prepare("INSERT INTO `$this->tableName` (`bookId`, `userId`, `rating`, `comments`) VALUES (?, ?, ?, ?);");
        $query->execute(array($bookId, $userId, $rating, $comment)); 
        return  $this->db->lastInsertId();
    }

    public function updateOne(){
    }

    public function parseCriteria($criteria){
        $possibleCriterias = array(
            "reviewId" => "R.id",
            "bookId" => "R.bookId",
            "authorId" => "R.authorId",
            "userId" => "R.userId",
            "rating" => "R.rating",
            "comments" => "R.comments",
            "bookTitle" => "B.title",
            "authorName" => "A.name",
            "authorLastName" => "A.last_name",
            "userAlias" => "U.alias",
        );
        return isset($possibleCriterias[$criteria]) ? $possibleCriterias[$criteria] : null ;
    }
}