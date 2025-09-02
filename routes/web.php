<?php

use App\Http\Controllers\Backend\ActiveUserController;
use App\Http\Controllers\Backend\BlogController;
use App\Http\Controllers\Backend\ReviewController;
use App\Http\Controllers\Backend\RoleController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\InstructorController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Backend\CategoryController;
use App\Http\Controllers\Backend\CourseController;
use App\Http\Controllers\Frontend\IndexController;
use App\Http\Controllers\Frontend\WishListController;
use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Backend\CouponController;
use App\Http\Controllers\Backend\SettingController;
use App\Http\Controllers\Backend\OrderController;
use App\Http\Controllers\Backend\QuestionController;
use App\Http\Middleware\RedirectIfAuthenticated;
use App\Http\Controllers\Backend\ReportController;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [UserController::class, 'Index'])->name('index');

Route::get('/dashboard', function () {
    return view('frontend.dashboard.index');
})->middleware(['auth', 'roles:user', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {

    Route::get('/user/profile', [UserController::class, 'UserProfile'])->name('user.profile');
    Route::post('/user/profile/update', [UserController::class, 'UserProfileUpdate'])->name('user.profile.update');
    Route::get('/user/logout', [UserController::class, 'UserLogout'])->name('user.logout');
    Route::get('/user/change/password', [UserController::class, 'UserChangePassword'])->name('user.change.password');
    Route::post('/user/password/update', [UserController::class, 'UserPasswordUpdate'])->name('user.password.update');


    //User Wishlist All Route  
    Route::controller(WishListController::class)->group(function(){
        Route::get('/user/wishlist', 'AllWishlist')->name('user.wishlist'); 
        Route::get('/get-wishlist-course/', 'GetWishlistCourse');
        Route::get('/remove-wishlist/{id}', 'RemoveWishlist');

    });

    
    //User "My-Course" Route 
    Route::controller(OrderController::class)->group(function(){
        Route::get('/my/course', 'MyCourse')->name('my.course');
        Route::get('/course/view/{course_id}', 'CourseView')->name('course.view'); 
    });

    //User Course-Questions Route 
    Route::controller(QuestionController::class)->group(function(){
        Route::post('/user/question', 'UserQuestion')->name('user.question'); 
    });
});

require __DIR__.'/auth.php';

///Admin Group Middleware  
Route::middleware(['auth','roles:admin'])->group(function(){
    Route::get('/admin/dashboard', [AdminController::class, 'AdminDashboard'])->name('admin.dashboard');
    Route::get('/admin/logout', [AdminController::class, 'AdminLogout'])->name('admin.logout');

    Route::get('/admin/profile', [AdminController::class, 'AdminProfile'])->name('admin.profile');
    Route::post('/admin/profile/store', [AdminController::class, 'AdminProfileStore'])->name('admin.profile.store');
    Route::get('/admin/change/password', [AdminController::class, 'AdminChangePassword'])->name('admin.change.password');
    Route::post('/admin/password/update', [AdminController::class, 'AdminPasswordUpdate'])->name('admin.password.update');


    //Category All Route   
    Route::controller(CategoryController::class)->group(function(){
        Route::get('/all/category', 'AllCategory')->name('all.category'); 
        Route::get('/add/category', 'AddCategory')->name('add.category');
        Route::post('/store/category', 'StoreCategory')->name('store.category');
        Route::get('/edit/category/{id}', 'EditCategory')->name('edit.category');
        Route::post('/update/category', 'UpdateCategory')->name('update.category');
        Route::get('/delete/category/{id}', 'DeleteCategory')->name('delete.category');
    });

    //Sub-Category All Route   
    Route::controller(CategoryController::class)->group(function(){
        Route::get('/all/subcategory', 'AllSubCategory')->name('all.subcategory'); 
        Route::get('/add/subcategory', 'AddSubCategory')->name('add.subcategory');
        Route::post('/store/subcategory', 'StoreSubCategory')->name('store.subcategory');
        Route::get('/edit/subcategory/{id}', 'EditSubCategory')->name('edit.subcategory');
        Route::post('/update/subcategory', 'UpdateSubCategory')->name('update.subcategory');
        Route::get('/delete/subcategory/{id}', 'DeleteSubCategory')->name('delete.subcategory');
    });

    //Admin Instructors All Route
    Route::controller(AdminController::class)->group(function(){
        Route::get('/all/instructor', 'AllInstructor')->name('all.instructor'); 
        Route::post('/update/user/status', 'UpdateUserStatus')->name('update.user.status'); 
    });

    //Admin Courses All Route   
    Route::controller(AdminController::class)->group(function(){
        Route::get('/admin/all/courses', 'AdminAllCourses')->name('admin.all.courses'); 
        Route::post('/update/course/status', 'UpdateCourseStatus')->name('update.course.status'); 
        Route::get('/admin/course/details/{id}', 'AdminCourseDetails')->name('admin.course.details');
    });

    //Admin Coupon All Route     
    Route::controller(CouponController::class)->group(function(){
        Route::get('/admin/all/coupons', 'AdminAllCoupons')->name('admin.all.coupons');
        Route::get('/admin/add/coupon', 'AdminAddCoupon')->name('admin.add.coupon');
        Route::post('/admin/store/coupon', 'AdminStoreCoupon')->name('admin.store.coupon'); 
        Route::get('/admin/edit/coupon/{id}', 'AdminEditCoupon')->name('admin.edit.coupon');
        Route::post('/admin/update/coupon/', 'AdminUpdateCoupon')->name('admin.update.coupon');
        Route::get('/admin/delete/coupon/{id}', 'AdminDeleteCoupon')->name('admin.delete.coupon');

    });

    //Admin SMTP Settings All Route 
    Route::controller(SettingController::class)->group(function(){
        Route::get('/smtp/setting', 'SmtpSetting')->name('smtp.setting');
        Route::post('/update/smtp', 'UpdateSmtp')->name('update.smtp');
    });

    //Admin Site Settings All Route   
    Route::controller(SettingController::class)->group(function(){
        Route::get('/site/setting', 'SiteSetting')->name('site.setting');
        Route::post('/update/site', 'UpdateSite')->name('update.site');

    });


    //Admin Order All Route   
    Route::controller(OrderController::class)->group(function(){
        Route::get('/admin/pending/orders', 'AdminPendingOrders')->name('admin.pending.orders');
        Route::get('/admin/order/details/{id}', 'AdminOrderDetails')->name('admin.order.details');
        Route::get('/admin/confirm/pending/order/{id}', 'AdminConfirmPendingOrder')->name('admin.confirm-pending-order');
        Route::get('/admin/confirmed/orders', 'AdminConfirmedOrders')->name('admin.confirmed.orders');
    });

    //Admin Report All Route   report.view
    Route::controller(ReportController::class)->group(function(){
        Route::get('/report/view', 'AdminReportView')->name('report.view');
        Route::post('/search/by/date','SearchByDate')->name('search.by.date');
        Route::post('/search/by/month', 'SearchByMonth')->name('search.by.month');
        Route::post('/search/by/year', 'SearchByYear')->name('search.by.year');
    });

     //Admin Reviews and Ratings All Route  
    Route::controller(ReviewController::class)->group(function(){
        Route::get('/admin/pending/review', 'AdminPendingReview')->name('admin.pending.review');
        Route::post('/update/review/status', 'UpdateReviewStatus')->name('update.review.status');
        Route::get('/admin/approved/review', 'AdminApprovedReview')->name('admin.approved.review');
    });

    //Admin All User and Instrutor Routes  
    Route::controller(ActiveUserController::class)->group(function(){
        Route::get('/admin/all/user', 'AdminAllUser')->name('admin.all.user');
        Route::get('/admin/all/instructor', 'AdminAllInstructor')->name('admin.all.instructor');
    });

    //Admin Blog Category All Routes 
    Route::controller(BlogController::class)->group(function(){
        Route::get('/admin/blog/category', 'AdminBlogCategory')->name('admin.blog.category');
        Route::post('/blog/category/store', 'BlogCategoryStore')->name('blog.category.store');
        Route::get('/edit/blog/category/{id}', 'EditBlogCategory');
        Route::post('/blog/category/update', 'BlogCategoryUpdate')->name('blog.category.update');
        Route::get('/delete/blog/category/{id}', 'DeleteBlogCategory')->name('delete.blog.category');
    });

    //Admin Blog Post All Routes 
    Route::controller(BlogController::class)->group(function(){
        Route::get('/admin/blog/post', 'AdminBlogPost')->name('admin.blog.post');
        Route::get('/add/blog/post', 'AddBlogPost')->name('add.blog.post');
        Route::post('/store/blog/post', 'StoreBlogPost')->name('store.blog.post');
        Route::get('/edit/blog/post/{id}', 'EditBlogPost')->name('edit.blog.post');
        Route::post('/update/blog/post', 'UpdateBlogPost')->name('update.blog.post');
        Route::get('/delete/blog/post/{id}', 'DeleteBlogPost')->name('delete.blog.post');
    });

    //Admin Permission All Routes  
    Route::controller(RoleController::class)->group(function(){
        Route::get('/all/permission', 'AllPermission')->name('all.permission');
        Route::get('/add/permission', 'AddPermission')->name('add.permission');
        Route::post('/store/permission', 'StorePermission')->name('store.permission');
        Route::get('/edit/permission/{id}', 'EditPermission')->name('edit.permission');
        Route::post('/update/permission', 'UpdatePermission')->name('update.permission');
        Route::get('/delete/permission/{id}', 'DeletePermission')->name('delete.permission');
        Route::get('/import/permission', 'ImportPermission')->name('import.permission');
        Route::get('/export', 'Export')->name('export');
        Route::post('/import', 'Import')->name('import');

    });

    //Admin Roles All Routes    all.admin  
    Route::controller(RoleController::class)->group(function(){
        Route::get('/all/roles', 'AllRoles')->name('all.roles');
        Route::get('/add/roles', 'AddRoles')->name('add.roles');
        Route::post('/store/roles', 'StoreRoles')->name('store.roles');
        Route::get('/edit/roles/{id}', 'EditRoles')->name('edit.roles');
        Route::post('/update/roles', 'UpdateRoles')->name('update.roles');
        Route::get('/delete/roles/{id}', 'DeleteRoles')->name('delete.roles');

        // Route::get('/add/roles/permission', 'AddRolesPermission')->name('add.roles.permission');
        Route::post('/role/permission/store', 'RolePermissionStore')->name('role.permission.store');
        Route::get('/all/roles/permission', 'AllRolesPermission')->name('all.roles.permission');
        Route::get('/admin/edit/roles/{id}', 'AdminEditRoles')->name('admin.edit.roles');
        Route::post('/admin/roles/update/{id}', 'AdminRolesUpdate')->name('admin.roles.update');
        Route::get('/admin/delete/roles/{id}', 'AdminDeleteRoles')->name('admin.delete.roles'); 
    });

    //Admin User All Routes  
    Route::controller(AdminController::class)->group(function(){
        Route::get('/all/admin', 'AllAdmin')->name('all.admin');
        Route::get('/add/admin', 'AddAdmin')->name('add.admin');
        Route::post('/store/admin', 'StoreAdmin')->name('store.admin');
        Route::get('/add/admin/{id}', 'EditAdmin')->name('edit.admin');
        Route::post('/update/admin/{id}', 'UpdateAdmin')->name('update.admin');
        Route::get('/delete/admin/{id}', 'DeleteAdmin')->name('delete.admin');
    });

    

});

Route::get('/admin/login', [AdminController::class, 'AdminLogin'])->name('admin.login')->middleware(RedirectIfAuthenticated::class);

Route::get('/become/instructor', [AdminController::class, 'BecomeInstructor'])->name('become.instructor');

Route::post('/instructor/register', [AdminController::class, 'InstructorRegister'])->name('instructor.register');



///Instructor Group Middleware 
Route::middleware(['auth','roles:instructor'])->group(function(){
    Route::get('/instructor/dashboard', [InstructorController::class, 'InstructorDashboard'])->name('instructor.dashboard');
    Route::get('/instructor/logout', [InstructorController::class, 'InstructorLogout'])->name('instructor.logout');

    Route::get('/instructor/profile', [InstructorController::class, 'InstructorProfile'])->name('instructor.profile');
    Route::post('/instructor/profile/store', [InstructorController::class, 'InstructorProfileStore'])->name('instructor.profile.store');
    Route::get('/instructor/change/password', [InstructorController::class, 'InstructorChangePassword'])->name('instructor.change.password');
    Route::post('/instructor/password/update', [InstructorController::class, 'InstructorPasswordUpdate'])->name('instructor.password.update');


    //Instructors All Route 
    Route::controller(CourseController::class)->group(function(){
        Route::get('/all/course', 'AllCourse')->name('all.course'); 
        Route::get('/add/course', 'AddCourse')->name('add.course');


        Route::get('/subcategory/ajax/{category_id}', 'GetSubCategory');

        Route::post('/store/course', 'StoreCourse')->name('store.course');

        Route::get('/edit/course/{id}', 'EditCourse')->name('edit.course');
        Route::post('/update/course', 'UpdateCourse')->name('update.course');

        Route::post('/update/course/image', 'UpdateCourseImage')->name('update.course.image');
        Route::post('/update/course/video', 'UpdateCourseVideo')->name('update.course.video');

        Route::post('/update/course/goals', 'UpdateCourseGoals')->name('update.course.goals');
        Route::get('/delete/course/{id}', 'DeleteCourse')->name('delete.course');
        
    }); 

    //Course Lecture and Section  All Route
    Route::controller(CourseController::class)->group(function(){
        Route::get('/add/course/lecture/{id}', 'AddCourseLecture')->name('add.course.lecture'); 

        Route::post('/add/course/section/', 'AddCourseSection')->name('add.course.section');
        
        Route::post('/save-lecture/', 'SaveLecture')->name('save-lecture');

        Route::get('/edit/lecture/{id}', 'EditLecture')->name('edit.lecture');

        Route::post('/update/course/lecture', 'UpdateCourseLecture')->name('update.course.lecture');

        Route::get('/delete/lecture/{id}', 'DeleteLecture')->name('delete.lecture');

        Route::post('/delete/section/{id}', 'DeleteSection')->name('delete.section'); 
        
    });


    //Instructor Order All Route   
    Route::controller(OrderController::class)->group(function(){
        Route::get('/instructor/all/orders', 'InstructorAllOrders')->name('instructor.all.orders');
        Route::get('/instructor/order/details/{payment_id}', 'InstructorOrderDetails')->name('instructor.order.details');
        Route::get('/instructor/order/invoice/{payment_id}', 'InstructorOrderInvoice')->name('instructor.order.invoice');
    });

    //Instructor Questions All Route   
    Route::controller(QuestionController::class)->group(function(){
        Route::get('/instructor/all/question', 'InstructorAllQuestion')->name('instructor.all.question');
        Route::get('/instructor/question/detail/{id}', 'InstructorQuestionDetails')->name('instructor.question.details');
        Route::post('/instructor/question/reply', 'InstructorQuestionReplay')->name('instructor.question.reply');
    });

    //Instructor Coupons All Route   
    Route::controller(CouponController::class)->group(function(){
        Route::get('/instructor/all/coupon', 'InstructorAllCoupon')->name('instructor.all.coupon');
        Route::get('/instructor/add/coupon', 'InstructorAddCoupon')->name('instructor.add.coupon');
        Route::post('/instructor/store/coupon', 'InstructorStoreCoupon')->name('instructor.store.coupon');
        Route::get('/instructor/edit/coupon/{id}', 'InstructorEditCoupon')->name('instructor.edit.coupon');
        Route::post('/instructor/update/coupon', 'InstructorUpdateCoupon')->name('instructor.update.coupon');
        Route::get('/instructor/delete/coupon/{id}', 'InstructorDeleteCoupon')->name('instructor.delete.coupon');
    });

    // Instructor Review All Route 
    Route::controller(ReviewController::class)->group(function(){
        Route::get('/instructor/all/review','InstructorAllReview')->name('instructor.all.review');  
    
    });
    

});


////Routes accessible by or for ALL
Route::get('/instructor/login', [InstructorController::class, 'InstructorLogin'])->name('instructor.login')->middleware(RedirectIfAuthenticated::class);

Route::get('/course/details/{id}/{slug}', [IndexController::class, 'CourseDetails']);

Route::get('/category/{id}/{slug}', [IndexController::class, 'CategoryCourse']);

Route::get('/subcategory/{id}/{slug}', [IndexController::class, 'SubCategoryCourse']);

Route::get('/instructor/details/{id}', [IndexController::class, 'InstructorDetails'])->name('instructor.details');

Route::post('/add-to-wishlist/{course_id}', [WishListController::class, 'AddToWishList']);

Route::post('/store/cart/data/{id}', [CartController::class, 'AddToCart']);

Route::post('/buy/data/course/{id}', [CartController::class, 'BuyToCart']);

Route::get('/cart/data/', [CartController::class, 'CartData']);

// Get Data from Minicart on the navbar
Route::get('/nav/cart/course/', [CartController::class, 'GetMiniCart']);
//End///

/// Remove Course from Minicart on the navbar
Route::get('/remove/cart/course/{rowId}', [CartController::class, 'RemoveMiniCart']);
//End///


//Cart All Route   
Route::controller(CartController::class)->group(function(){
    Route::get('/my-cart', 'MyCart')->name('cart'); 
    Route::get('/get-my-cart', 'GetMyCart'); 
    Route::get('/remove-cart/{rowId}', 'RemoveMyCart'); 

});


Route::post('/apply-coupon', [CartController::class, 'ApplyCoupon']);

Route::post('/inscoupon-apply', [CartController::class, 'InsApplyCoupon']);

Route::get('/coupon_calculation', [CartController::class, 'CouponCalculation']);

Route::get('/coupon-remove', [CartController::class, 'CouponRemove']);


//// Checkout Page Route ///// mark-notification-as-read
Route::get('/checkout', [CartController::class, 'CheckoutCreate'])->name('checkout');

Route::post('/payment', [CartController::class, 'Payment'])->name('payment');

Route::post('/stripe_order', [CartController::class, 'StripeOrder'])->name('stripe_order');

Route::post('/store/review', [ReviewController::class, 'StoreReview'])->name('store.review');

Route::get('/blog/detials/{slug}', [BlogController::class, 'BlogDetails']);

Route::get('/blog/cat/list/{id}', [BlogController::class, 'BlogCatList']);

Route::get('/blog', [BlogController::class, 'Blog'])->name('blog');

Route::post('/mark-notification-as-read/{notification}', [CartController::class, 'MarkAsRead']);




