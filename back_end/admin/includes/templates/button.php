
<!-- Add Modal -->
<div class="modal fade" id="add" tabindex="-1" role="dialog" aria-labelledby="addlabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h2 class="text-light">اضافة عضو </h2>
            </div>
            <form class="float-right" action="insert.php" method="POST">
                <div class="modal-body">
                        <div class="form-group ">
                            <h4>الاسم</h4>
                            <input type="text" name="username" autocomplete="off"  placeholder=" اسم المستخدم " required class="form-control inputName " id="Name ">
                        </div>
                        <div class="form-group ">
                            <h4>البريد الالكترونى</h4>
                            <input type="email" name="email" class="form-control Description"  placeholder="البريد الالكترونى يجب ان يكون صحيح" required >
                        </div>
                        <div class="form-group ">
                            <h4>كلمة المرور</h4>
                            <input type="password" name="password"  class="form-control Description "  autocomplete="new-password" placeholder="الرقم السرى يجب ان يكون صعب توقعة" required>
                        </div>
                        <div class="form-group ">
                            <h4>الصف</h4>
                            <select class="custom-select form-control" name="parent">
                                <option value="1">الصف الاول الاعدادى</option>
                                <option value="2">الصف الثاني الاعدادى</option>
                                <option value="3">الصف الثالث الاعدادى</option>
                                <option value="4">الصف الاول الثانوى</option>
                                <option value="5">الصف الثانى الثانوى</option>
                                <option value="6">الصف الثالث الثانوى</option>
                            </select>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="submit " class="btn btn-info" name="add_member">اضافة عضو</button>    
                    <button type="button " class="btn btn-secondary" data-dismiss="modal">الغاء</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--edit modal-->
<div class="modal fade" id="edit" tabindex="-1" aria-labelledby="editLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-success">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="float-right">
                    <div class="form-group">
                        <label for="x1" ">الاول</label>
                        <input type="text" class="form-control Description" value="اى حاجه" >
                    </div>
                    <div class="form-group">
                        <label for="x2" class="x2">الثانى</label>
                        <input type="text" class="form-control Note" value="اى حاجه">
                    </div>
                    <div class="form-group ">
                        <label for="x3" class="x3">الثالث</label>
                        <input type="text" class="form-control Note" value="اى حاجه" >
                    </div>
                    <div class="form-group ">
                        <label for="x4">تاريخ مثلا</label>
                        <input type="datetime" value="27/11/2020" class="time">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success">حفظ</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">الغاء</button>
            </div>
        </div>
    </div>
</div>

<!--  remove Modal -->
<div class="modal fade" id="remove" tabindex="-1" aria-labelledby="removeLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <h2 class="text-light">حزف عضو </h2>
            </div>
            <div class="modal-body">
                هل تريد حذف هذا الشخص
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger">حذف</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">الغاء</button>
            </div>
        </div>
    </div>
</div>