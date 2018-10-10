### 最快                                                                                                                                                        ```sql
```sql                                    
SELECT count(*) AS AGGREGATE
FROM `oa_q_questions`
       INNER JOIN (SELECT * FROM oa_q_question_knowledges WHERE knowledge_id = 6) AS `oa_qk`
         ON `oa_q_questions`.`id` = `oa_qk`.`question_id`
WHERE `oa_qk`.`knowledge_id` = 6
  AND `question_status` = 4
  AND `grade_range_subject_id` = 1
  AND `oa_q_questions`.`deleted_at` IS NULL;
```


### 第二
```sql 
SELECT count(*) AS AGGREGATE
FROM `oa_q_questions`
       INNER JOIN `oa_q_question_knowledges` AS `oa_qk` ON `oa_q_questions`.`id` = `oa_qk`.`question_id`
WHERE `oa_qk`.`knowledge_id` = 6
  AND `question_status` = 4
  AND `grade_range_subject_id` = 1
  AND `oa_q_questions`.`deleted_at` IS NULL;
```


### 最慢
```sql 
SELECT count(*) AS AGGREGATE
FROM `oa_q_questions`
WHERE EXISTS(
        SELECT 1
        FROM `oa_q_question_knowledges`
        WHERE oa_q_questions.id = oa_q_question_knowledges.question_id
          AND oa_q_question_knowledges.knowledge_id = 6
        )
  AND `question_status` = 4
  AND `grade_range_subject_id` = 1
  AND `oa_q_questions`.`deleted_at` IS NULL;
```
