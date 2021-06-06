<?php include "dbcon.php"; ?>

<?php
  if(isset($_POST['basic-info-update'])){
		$lesson_code = $_POST['lesson-code'];

		// Παίρνουμε τα δεδομένα από τη ΒΔ
		$sql = "SELECT cat_id, semester, ects, lang, curriculum, teaching_method,
		grade_method, title_eng, curriculum_eng, teaching_method_eng,  url, where_id, lang_en, erasmus FROM lesson WHERE lesson_code = ?";
		$stmt = $pdo->prepare($sql);
		$stmt->execute([$lesson_code]);
		$lesson_previous_values = $stmt->fetch();
		

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
		$title_eng = $_POST['title-eng'];
		$ects = $_POST['ects'];
		$semester = $_POST['semester'];
		$lesson_type_id = $_POST['lesson-type'];
		$language = $_POST['language'];
		$language_eng = $_POST['language-eng'];
		$erasmus = $_POST['erasmus'];
		$url = $_POST['url'];
		$teaching_methods = trim($_POST['teaching-methods']);
		$teaching_methods_eng = trim($_POST['teaching-methods-eng']);
		$curriculum = trim($_POST['curriculum']);
		$curriculum_eng = trim($_POST['curriculum-eng']);
		$where_teaching_id = $_POST['where-teaching'];
		$grade_method = trim($_POST['grade-method']);
		// Πίνακας με τις νέες τιμές 
		$lesson_new_values = [];
		$lesson_new_values["cat_id"] = $category_id;
		$lesson_new_values["semester"] = $semester;
		$lesson_new_values["ects"] = $ects;
		$lesson_new_values["lang"] = $language;
		$lesson_new_values["curriculum"] = $curriculum;
		$lesson_new_values["teaching_method"] = $teaching_methods;
		$lesson_new_values["grade_method"] = $grade_method;
		$lesson_new_values["title_eng"] = $title_eng;
		$lesson_new_values["curriculum_eng"] = $curriculum_eng;
		$lesson_new_values["teaching_method_eng"] = $teaching_methods_eng;
		$lesson_new_values["url"] = $url;
		$lesson_new_values["where_id"] = $where_teaching_id;
		$lesson_new_values["lang_en"] = $language_eng;
		$lesson_new_values["erasmus"] = $erasmus;

		$diff=array_diff($lesson_new_values, $lesson_previous_values);
		$section = "Βασικές Πληροφορίες";
		foreach($diff as $field => $new_value) {
			$sql = "INSERT INTO log (teacher_id, lesson_id, section, field, previous_value, new_value) 
							VALUES (?, ?, ?, ?, ?, ?)";
			$stmt = $pdo->prepare($sql);
			$stmt->execute([$_SESSION['user_id'], $lesson_code, $section, $field, $lesson_previous_values[$field], $new_value]);
		}

		// Ενημέρωση για προαπαιτούμενα μαθήματα
		// Ανάκτηση Δεδομένων από τη Βάση
		$sql = "SELECT requirement_id FROM lesson_prereq WHERE lesson_code = ?";
		$stmt = $pdo->prepare($sql);
		$stmt->execute([$lesson_code]);
		$prev_lessons = $stmt->fetchAll();
		$previous_lessons = [];
		foreach($prev_lessons as $prev_lesson){
			foreach($prev_lesson as $lesson){
				array_push($previous_lessons, $lesson);
			}
		}
		$prereq_lessons = array_merge($group_a_prereq_lessons, $group_b_prereq_lessons); 
		// Ενημέρωση του log
		$section = "Προαπαιτούμενα Μαθήματα";
		$diff1=array_diff($previous_lessons, $prereq_lessons);
		$fld = "Αφαιρέθηκε";
		foreach($diff1 as $field => $prev_value) {
			$sql = "INSERT INTO log (teacher_id, lesson_id, section, field, previous_value, new_value) 
							VALUES (?, ?, ?, ?, ?, ?)";
			$stmt = $pdo->prepare($sql);
			$stmt->execute([$_SESSION['user_id'], $lesson_code, $section, $fld, $prev_value, ""]);
		}

		$diff2=array_diff($prereq_lessons, $previous_lessons);
		$fld = "Προστέθηκε";
		foreach($diff2 as $field => $new_value) {
			$sql = "INSERT INTO log (teacher_id, lesson_id, section, field, previous_value, new_value) 
							VALUES (?, ?, ?, ?, ?, ?)";
			$stmt = $pdo->prepare($sql);
			$stmt->execute([$_SESSION['user_id'], $lesson_code, $section, $fld, "", $new_value]);
		}

		// Eνημέρωση πίνακα lessons
		$sql = "UPDATE lesson SET cat_id = ?, semester = ?, semester_current = ?, 
															ects = ?, lang = ?, curriculum = ?, teaching_method = ?,
															grade_method = ?, title_eng = ?, curriculum_eng = ?, teaching_method_eng = ?,  url = ?, where_id = ?, lang_en = ?, erasmus = ?
													WHERE lesson_code = ?";
		$stmt = $pdo->prepare($sql);
		$stmt->execute([$category_id, $semester, $semester, $ects, $language, $curriculum,
										$teaching_methods, $grade_method, $title_eng, $curriculum_eng, $teaching_methods_eng, $url, $where_teaching_id, $language_eng, $erasmus, $lesson_code]);

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
		header("Location: ../lesson.php?lesson_id=$lesson_code" . "#section-one");
	}

	if(isset($_POST['update-abilities'])){
		$abilities = $_POST['ability'];
		$lesson_code = trim($_POST['lesson-code']);

		// Ανάκτηση Δεδομένων από τη Βάση
		$sql = "SELECT ability_id FROM ability2lesson WHERE lesson_code = ?";
		$stmt = $pdo->prepare($sql);
		$stmt->execute([$lesson_code]);
		$prev_abilities = $stmt->fetchAll();
		$previous_abilities = [];
		foreach($prev_abilities as $prev_ability){
			foreach($prev_ability as $ability){
				array_push($previous_abilities, $ability);
			}
		}

		// Ενημέρωση του log
		$section = "Αποκτόμενες Ικανότητες";
		$diff1=array_diff($previous_abilities, $abilities);
		$fld = "Αφαιρέθηκε";
		foreach($diff1 as $field => $prev_value) {
			$sql = "INSERT INTO log (teacher_id, lesson_id, section, field, previous_value, new_value) 
							VALUES (?, ?, ?, ?, ?, ?)";
			$stmt = $pdo->prepare($sql);
			$stmt->execute([$_SESSION['user_id'], $lesson_code, $section, $fld, $prev_value, ""]);
		}
	
		$diff2=array_diff($abilities, $previous_abilities);
		$fld = "Προστέθηκε";
		foreach($diff2 as $field => $new_value) {
			$sql = "INSERT INTO log (teacher_id, lesson_id, section, field, previous_value, new_value) 
							VALUES (?, ?, ?, ?, ?, ?)";
			$stmt = $pdo->prepare($sql);
			$stmt->execute([$_SESSION['user_id'], $lesson_code, $section, $fld, "", $new_value]);
		}

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
		header("Location: ../lesson.php?lesson_id=$lesson_code" . "#section-two");
	}

	if(isset($_POST['update-assessments-methods'])){
		$assessments = $_POST['assessment'];
		$lesson_code = trim($_POST['lesson-code']);

		// Ανάκτηση Δεδομένων από τη Βάση
		$sql = "SELECT assessment_id FROM assessment2lesson WHERE lesson_code = ?";
		$stmt = $pdo->prepare($sql);
		$stmt->execute([$lesson_code]);
		$prev_assessments = $stmt->fetchAll();
		$previous_assessments = [];
		foreach($prev_assessments as $prev_assessment){
			foreach($prev_assessment as $assessment){
				array_push($previous_assessments, $assessment);
			}
		}

		// Ενημέρωση του log
		$section = "Μάθοδοι Αξιολόγησης";
		$diff1=array_diff($previous_assessments, $assessments);
		$fld = "Αφαιρέθηκε";
		foreach($diff1 as $field => $prev_value) {
			$sql = "INSERT INTO log (teacher_id, lesson_id, section, field, previous_value, new_value) 
							VALUES (?, ?, ?, ?, ?, ?)";
			$stmt = $pdo->prepare($sql);
			$stmt->execute([$_SESSION['user_id'], $lesson_code, $section, $fld, $prev_value, ""]);
		}
	
		$diff2=array_diff($assessments, $previous_assessments);
		$fld = "Προστέθηκε";
		foreach($diff2 as $field => $new_value) {
			$sql = "INSERT INTO log (teacher_id, lesson_id, section, field, previous_value, new_value) 
							VALUES (?, ?, ?, ?, ?, ?)";
			$stmt = $pdo->prepare($sql);
			$stmt->execute([$_SESSION['user_id'], $lesson_code, $section, $fld, "", $new_value]);
		}

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
		header("Location: ../lesson.php?lesson_id=$lesson_code" . "#section-two");
	}

	if(isset($_POST['update-tech-methods'])){
		$techs = $_POST['tech'];
		$lesson_code = $_POST['lesson_code'];

		// Ανάκτηση Δεδομένων από τη Βάση
		$sql = "SELECT tech_id FROM tech2lesson WHERE lesson_code = ?";
		$stmt = $pdo->prepare($sql);
		$stmt->execute([$lesson_code]);
		$prev_techs = $stmt->fetchAll();
		$previous_techs = [];
		foreach($prev_techs as $prev_tech){
			foreach($prev_tech as $tech){
				array_push($previous_techs, $tech);
			}
		}

		// Ενημέρωση του log
		$section = "Χρήση Τεχνολογιών";
		$diff1=array_diff($previous_techs, $techs);
		$fld = "Αφαιρέθηκε";
		foreach($diff1 as $field => $prev_value) {
			$sql = "INSERT INTO log (teacher_id, lesson_id, section, field, previous_value, new_value) 
							VALUES (?, ?, ?, ?, ?, ?)";
			$stmt = $pdo->prepare($sql);
			$stmt->execute([$_SESSION['user_id'], $lesson_code, $section, $fld, $prev_value, ""]);
		}
	
		$diff2=array_diff($techs, $previous_techs);
		$fld = "Προστέθηκε";
		foreach($diff2 as $field => $new_value) {
			$sql = "INSERT INTO log (teacher_id, lesson_id, section, field, previous_value, new_value) 
							VALUES (?, ?, ?, ?, ?, ?)";
			$stmt = $pdo->prepare($sql);
			$stmt->execute([$_SESSION['user_id'], $lesson_code, $section, $fld, "", $new_value]);
		}

		
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
		header("Location: ../lesson.php?lesson_id=$lesson_code" . "#section-three");
	}

	if(isset($_POST['update-organize-teaching'])){
		// Nέα δεδομένα
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

		// Παλία δεδομένα
		$sql = "SELECT * FROM teaching2lesson WHERE lesson_code = ?";
		$stmt = $pdo->prepare($sql);
		$stmt->execute([$lesson_code]);
		$previous_values = $stmt->fetchAll();

		$prev_hours['δια'] = '';
		$prev_hours['σεμ'] = '';
		$prev_hours['εργ-ασκ'] = '';
		$prev_hours['ασκ-πεδ'] = '';
		$prev_hours['μελ-βιβ'] = '';
		$prev_hours['φρο'] = '';
		$prev_hours['πρα-ασκ'] = '';
		$prev_hours['κλι-ασκ'] = '';
		$prev_hours['καλ-εργ'] = '';
		$prev_hours['δια-διδ'] = '';
		$prev_hours['εκπ-επι'] = '';
		$prev_hours['εκπ-μελ'] = '';
		$prev_hours['συγ-εργ'] = '';
		$prev_hours['καλ-δημ'] = '';
		$prev_hours['μελ'] = '';
		
		foreach($previous_values as $value){
			$prev_hours[$value['teaching_id']] = $value['hours'];
		}

		$section = "Οργάνωση Διδασκαλίας";
		foreach($prev_hours as $key => $value){
			if($value != $hours[$key]){
				$sql = "INSERT INTO log (teacher_id, lesson_id, section, field, previous_value, new_value) 
							VALUES (?, ?, ?, ?, ?, ?)";
				$stmt = $pdo->prepare($sql);
				$stmt->execute([$_SESSION['user_id'], $lesson_code, $section, $key , $value, $hours[$key]]);
			}
		}


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
		header("Location: ../lesson.php?lesson_id=$lesson_code" ."#section-three");
	}

	if(isset($_POST['update-course-results'])){
		$lesson_code = $_POST['lesson-code'];
		$course_results = $_POST['course_results'];
		$aims = "";
		foreach($course_results as $result){
			$aims .= "item " . $result;
		}

		// Ανάκτηση Δεδομένων από τη Βάση
		$sql = "SELECT aims FROM lesson WHERE lesson_code = ?";
		$stmt = $pdo->prepare($sql);
		$stmt->execute([$lesson_code]);
		$previous_aims = $stmt->fetch();
		$prev_results = explode("item", $previous_aims['aims']);
		unset($prev_results[0]);

		// Ενημέρωση του log
		$section = " Μαθησιακά Αποτελέσματα";
		$diff1=array_diff($prev_results, $course_results);
		$fld = "Αφαιρέθηκε";
		foreach($diff1 as $field => $prev_value) {
			$sql = "INSERT INTO log (teacher_id, lesson_id, section, field, previous_value, new_value) 
			 				VALUES (?, ?, ?, ?, ?, ?)";
			$stmt = $pdo->prepare($sql);
			$stmt->execute([$_SESSION['user_id'], $lesson_code, $section, $fld, $prev_value, ""]);
		}

		$diff2=array_diff($course_results, $prev_results);
		$fld = "Προστέθηκε";
		foreach($diff2 as $field => $new_value) {
			$sql = "INSERT INTO log (teacher_id, lesson_id, section, field, previous_value, new_value) 
			 				VALUES (?, ?, ?, ?, ?, ?)";
			$stmt = $pdo->prepare($sql);
			$stmt->execute([$_SESSION['user_id'], $lesson_code, $section, $fld, "", $new_value]);
		}

		// Eνημέρωση πίνακα lesson
		$sql = "UPDATE lesson SET aims = ? WHERE lesson_code = ?";
		$stmt = $pdo->prepare($sql);
		$stmt->execute([$aims, $lesson_code]);
		header("Location: ../lesson.php?lesson_id=$lesson_code" . "#section-two");
	}

	if(isset($_POST['update-books'])){
		$lesson_code = $_POST['lesson-code'];
		$books = $_POST['books_update'];

		// Ανάκτηση Δεδομένων από τη Βάση
		$sql = "SELECT book_id FROM book2lesson WHERE lesson_code = ?";
		$stmt = $pdo->prepare($sql);
		$stmt->execute([$lesson_code]);
		$prev_books = $stmt->fetchAll();
		$previous_books = [];
		foreach($prev_books as $prev_book){
			foreach($prev_book as $book){
				array_push($previous_books, $book);
			}
		}

		// Ενημέρωση του log
		$section = "Βιβλιογραφία";
		$diff1=array_diff($previous_books, $books);
		$fld = "Αφαιρέθηκε";
		foreach($diff1 as $field => $prev_value) {
			$sql = "INSERT INTO log (teacher_id, lesson_id, section, field, previous_value, new_value) 
							VALUES (?, ?, ?, ?, ?, ?)";
			$stmt = $pdo->prepare($sql);
			$stmt->execute([$_SESSION['user_id'], $lesson_code, $section, $fld, $prev_value, ""]);
		}
	
		$diff2=array_diff($books, $previous_books);
		$fld = "Προστέθηκε";
		foreach($diff2 as $field => $new_value) {
			$sql = "INSERT INTO log (teacher_id, lesson_id, section, field, previous_value, new_value) 
							VALUES (?, ?, ?, ?, ?, ?)";
			$stmt = $pdo->prepare($sql);
			$stmt->execute([$_SESSION['user_id'], $lesson_code, $section, $fld, "", $new_value]);
		}

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
		header("Location: ../lesson.php?lesson_id=$lesson_code" . "#section-four");
	}

?>