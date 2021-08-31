//members page
$('.delete').click(function() {
    $('#userid').val($(this).next('#userid_2').val());
});
$('.activiate').click(function() {
    $('#userid_3').val($(this).prev('#userid_2').val());
});
$('.edit').click(function() {
    $('#userid_4').val($(this).nextAll('#userid_2').val());
});
$('.not_activiate').click(function() {
    $('#cat_id_4').val($(this).prevAll('#userid_2').val());
});
//category page
$('.delete_cat').click(function() {
    $('#catid').val($(this).prev('#cat').val());
});
$('.edit_cat').click(function() {
    $('#cat_2').val($(this).next('#cat').val());
});
$('.activiate').click(function() {
    $('#cat_id_3').val($(this).prevAll('#cat').val());
});
$('.not_activiate').click(function() {
    $('#cat_id_4').val($(this).prevAll('#cat').val());
});
//lessons page
$('.lesson_edit').click(function() {
    $('#lesson_2').val($(this).next('#lesson').val());
});
$('.lesson_delete').click(function() {
    $('#lessonid_2').val($(this).prev('#lesson').val());
});
$('.activiate_lesson').click(function() {
    $('#lesson_id').val($(this).prevAll('#lesson').val());
});

//exam page
$('.exam_delete').click(function() {
    $('#examid').val($(this).prev('#exam').val());
});
$('.edit_exam').click(function() {
    $('#exam_2').val($(this).next('#exam').val());
});

//post-page
$('.delete_post').click(function() {
    $('#postid_2').val($(this).prev('#post').val());
});
$('.edit_post').click(function() {
    $('#post_2').val($(this).next('#post').val());
});
$('.delete').click(function() {
    $('#userid').val($(this).next('#userid_2').val());
});
$('.activiate').click(function() {
    $('#userid_3').val($(this).prev('#userid_2').val());
});
$('.edit').click(function() {
    $('#userid_4').val($(this).nextAll('#userid_2').val());
});
//category page
$('.delete_cat').click(function() {
    $('#catid').val($(this).prev('#cat').val());
});
$('.edit_cat').click(function() {
    $('#cat_2').val($(this).next('#cat').val());
});
//lessons page
$('.lesson_edit').click(function() {
    $('#lesson_2').val($(this).next('#lesson').val());
});
$('.lesson_delete').click(function() {
    $('#lessonid_2').val($(this).prev('#lesson').val());
});
$('.activiate_lesson').click(function() {
    $('#lesson_id').val($(this).prevAll('#lesson').val());
});
//exam page
$('.exam_delete').click(function() {
    $('#examid').val($(this).prev('#exam').val());
});
$('.edit_exam').click(function() {
    $('#exam_2').val($(this).next('#exam').val());
});
//question_id
$('.delete_ques').click(function() {
    $('#quesid').val($(this).next('#question_id').val());
});
//comment
$('.delete_comment').click(function() {
    $('#comment_id').val($(this).next('#comment').val());
});
$('.activiate_comment').click(function() {
    $('#comment_id_2').val($(this).prev('#comment').val());
});
//qoutes
$('.delete_ben').click(function() {
    $('#benfit_id').val($(this).next('#benfit').val());
});
//events
$('.delete_event').click(function() {
    $('#eventid_2').val($(this).prev('#event').val());
    console.log('hello');
});
$('.edit_event').click(function() {
    $('#event_2').val($(this).next('#event').val());
});