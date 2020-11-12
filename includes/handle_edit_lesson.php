<?php include "dbcon.php"; ?>

<?php
  if(isset($_POST['basic-info-update'])){
		$lesson_code = $_POST['lesson-code'];

		if(isset($_POST['group_a_lessons'])){
			$group_a_prereq_lessons = $_POST['group_a_lessons'];
		}else{
			$group_a_prereq_lessons = [];
		}
		
		if(isset($_POST['group_b_lessons'])){
			$group_b_prereq_lessons = $_POST['group_b_lessons'];
		}else{
			$group_b_prereq_lessons = [];
		}
		$category_id = $_POST['category'];
		$ects = $_POST['ects'];
		$semester = $_POST['semester'];
		$lesson_type_id = $_POST['lesson-type'];
		$language = $_POST['language'];
		$erasmus = $_POST['erasmus'];
		$url = $_POST['url'];
		$teaching_methods = $_POST['teaching-methods'];
		$curriculum = $_POST['curriculum'];
		$where_teaching_id = $_POST['where-teaching'];
		$grade_method = $_POST['grade-method'];

		// Eνημέρωση πίνακα lessons
		$sql = "UPDATE lesson SET cat_id = ?, semester = ?, semester_current = ?, 
															ects = ?, lang = ?, curriculum = ?, teaching_method = ?,
															grade_method = ?, url = ?, where_id = ?, erasmus = ?
													WHERE lesson_code = ?";
		$stmt = $pdo->prepare($sql);
		$stmt->execute([$category_id, $semester, $semester, $ects, $language, $curriculum,
										$teaching_methods, $grade_method, $url, $where_teaching_id, $erasmus, $lesson_code]);

		// Eνημέρωση πίνακα type2lesson
		$sql = "UPDATE type2lesson SET type_id = ? WHERE lesson_code = ?";
		$stmt = $pdo->prepare($sql);
		$stmt->execute([$lesson_type_id, $lesson_code]);

		// Ενημέρωση πίνακα lesson_prereq
		// Group 0
		$sql = "DELETE FROM lesson_prereq WHERE group_id = ? AND lesson_code= ? ";
		$stmt = $pdo->prepare($sql);
		$stmt->execute([0, $lesson_code]);

		$cnt = 1;
		foreach($group_a_prereq_lessons as $lesson){
			$sql = "INSERT INTO lesson_prereq(lesson_code, requirement_id, group_id, requirement_order) VALUES(?, ?, ?, ?)";
			$stmt = $pdo->prepare($sql);
			$stmt->execute([$lesson_code, $lesson, 0, $cnt]);
			$cnt++;
		}
		// Group 1
		$sql = "DELETE FROM lesson_prereq WHERE group_id = ? AND lesson_code= ?";
		$stmt = $pdo->prepare($sql);
		$stmt->execute([1, $lesson_code]);

		$cnt = 1;
		foreach($group_b_prereq_lessons as $lesson){
			$sql = "INSERT INTO lesson_prereq(lesson_code, requirement_id, group_id, requirement_order) VALUES(?, ?, ?, ?)";
			$stmt = $pdo->prepare($sql);
			$stmt->execute([$lesson_code, $lesson, 1, $cnt]);
			$cnt++;
		}
		header("Location: ../edit_lesson.php?lesson_id=$lesson_code");
	}

	if(isset($_POST['update-abilities'])){
		$abilities = $_POST['ability'];
		$lesson_code = $_POST['lesson-code'];

		// Διαγραφή των παλιών δεδομένων
		$sql = "DELETE FROM ability2lesson WHERE lesson_code= ?";
		$stmt = $pdo->prepare($sql);
		$stmt->execute([$lesson_code]);

		// Εισαγωγή των νέων δεδομένων
		foreach($abilities as $ability){
			$sql = "INSERT INTO ability2lesson(lesson_code, ability_id) VALUES(?, ?)";
			$stmt = $pdo->prepare($sql);
			$stmt->execute([$lesson_code, $ability]);
		}
		header("Location: ../edit_lesson.php?lesson_id=$lesson_code");
	}

	if(isset($_POST['update-assessments-methods'])){
		$assessments = $_POST['assessment'];
		$lesson_code = $_POST['lesson-code'];

		// Διαγραφή των παλιών δεδομένων
		$sql = "DELETE FROM assessment2lesson WHERE lesson_code= ?";
		$stmt = $pdo->prepare($sql);
		$stmt->execute([$lesson_code]);
		
		// Εισαγωγή των νέων δεδομένων
		foreach($assessments as $assessment){
			$sql = "INSERT INTO assessment2lesson(lesson_code, assessment_id) VALUES(?, ?)";
			$stmt = $pdo->prepare($sql);
			$stmt->execute([$lesson_code, $assessment]);
		}
		header("Location: ../edit_lesson.php?lesson_id=$lesson_code");
	}

	if(isset($_POST['update-tech-methods'])){
		$techs = $_POST['tech'];
		$lesson_code = $_POST['lesson_code'];
		
		// Διαγραφή των παλιών δεδομένων
		$sql = "DELETE FROM tech2lesson WHERE lesson_code= ?";
		$stmt = $pdo->prepare($sql);
		$stmt->execute([$lesson_code]);
		
		// Εισαγωγή των νέων δεδομένων
		foreach($techs as $tech){
			$sql = "INSERT INTO tech2lesson(lesson_code, tech_id) VALUES(?, ?)";
			$stmt = $pdo->prepare($sql);
			$stmt->execute([$lesson_code, $tech]);
		}
		header("Location: ../edit_lesson.php?lesson_id=$lesson_code");
	}

	if(isset($_POST['update-organize-teaching'])){
		$lesson_code = $_POST['lesson_code'];
		$hours['δια'] = $_POST['lecture'];
		$hours['σεμ'] = $_POST['seminar'];
		$hours['εργ-ασκ'] = $_POST['exercise_lab'];
		$hours['ασκ-πεδ'] = $_POST['field_exercise'];
		$hours['μελ-βιβ'] = $_POST['bibliography'];
		$hours['φρο'] = $_POST['coaching_school'];
		$hours['πρα-ασκ'] = $_POST['practise'];
		$hours['κλι-ασκ'] = $_POST['clinic'];
		$hours['καλ-εργ'] = $_POST['artistic_lab'];
		$hours['δια-διδ'] = $_POST['interactive_teaching'];
		$hours['εκπ-επι'] = $_POST['educational_visit'];
		$hours['εκπ-μελ'] = $_POST['project'];
		$hours['συγ-εργ'] = $_POST['assessment'];
		$hours['καλ-δημ'] = $_POST['artistic'];
		$hours['μελ'] = $_POST['unorder_study'];

		// Διαγραφή των παλιών δεδομένων
		$sql = "DELETE FROM teaching2lesson WHERE lesson_code= ?";
		$stmt = $pdo->prepare($sql);
		$stmt->execute([$lesson_code]);

		foreach($hours as $type => $number_of_hours){
			if($number_of_hours !== ""){
				$sql = "INSERT INTO teaching2lesson(lesson_code, teaching_id, hours) VALUES(?, ?, ?)";
				$stmt = $pdo->prepare($sql);
				$stmt->execute([$lesson_code, $type, $number_of_hours]);
			}
		}
		header("Location: ../edit_lesson.php?lesson_id=$lesson_code");
	}

	if(isset($_POST['update-course-results'])){
		$lesson_code = $_POST['lesson-code'];
		$course_results = $_POST['course_results'];
		$aims = "";
		foreach($course_results as $result){
			$aims .= "item " . $result;
		}
		echo $aims;
		// Eνημέρωση πίνακα lesson
		$sql = "UPDATE lesson SET aims = ? WHERE lesson_code = ?";
		$stmt = $pdo->prepare($sql);
		$stmt->execute([$aims, $lesson_code]);
		header("Location: ../edit_lesson.php?lesson_id=$lesson_code");
	}

	if(isset($_POST['update-books'])){
		$lesson_code = $_POST['lesson-code'];
		$books = $_POST['books_update'];

		// Διαγραφή των παλιών δεδομένων
		$sql = "DELETE FROM book2lesson WHERE lesson_code= ?";
		$stmt = $pdo->prepare($sql);
		$stmt->execute([$lesson_code]);
		
		// Εισαγωγή των νέων δεδομένων
		$cnt = 1;
		foreach($books as $book){
			$sql = "INSERT INTO book2lesson(lesson_code, book_id, book_order) VALUES(?, ?, ?)";
			$stmt = $pdo->prepare($sql);
			$stmt->execute([$lesson_code, $book, $cnt]);
			$cnt++;
		}
		header("Location: ../edit_lesson.php?lesson_id=$lesson_code");
	}

?>