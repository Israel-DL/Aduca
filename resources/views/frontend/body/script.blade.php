{{-- Start Wishlist Add Option  --}}
<script type="text/javascript">
    

    $.ajaxSetup({
        headers:{
            'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
        }
    })

    function addToWishList(course_id){

        $.ajax({
            type: "POST",
            dataType: 'json',
            url: "/add-to-wishlist/"+course_id,

            success: function(data){

                // Start Message 
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end', 
                    showConfirmButton: false,
                    timer: 3000 
                })
                  
                if ($.isEmptyObject(data.error)) {

                    Toast.fire({
                    type: 'success',
                    icon: 'success',
                    title: data.success, 
                  })

                }else{

                    Toast.fire({
                        type: 'error',
                        icon: 'error',
                        title: data.error,
                    })
                }
              // End Message   


            }
        })
    }


</script>
{{-- End Wishlist Add Option  --}}


{{-- Start Load Wishlist Data  --}}
<script type="text/javascript">

    function wishlist(){
        $.ajax({
          type: "GET",
          dataType: 'json',
          url: "/get-wishlist-course/",
          
          success: function(response){

            $('#wishlistQty').text(response.wishlistQty);
        
            var rows = ""
            $.each(response.wishlist, function(key, value){
                rows += `
                
                <div class="col-lg-4 responsive-column-half">
                    <div class="card card-item">
                        <div class="card-image">
                            <a href="/course/details/${value.course.id}/${value.course.course_name_slug}" class="d-block">
                                <img class="card-img-top" src="/${value.course.course_image}" alt="Card image cap">
                            </a>

                        </div><!-- end card-image -->
                        <div class="card-body">
                            <h6 class="ribbon ribbon-blue-bg fs-14 mb-3">${value.course.label}</h6>
                            <h5 class="card-title"><a href="/course/details/${value.course.id}/${value.course.course_name_slug}">${value.course.course_name}</a></h5>

                            <div class="d-flex justify-content-between align-items-center">

                                ${value.course.discount_price == null  
                                ?`<p class="card-price text-black font-weight-bold"> ₦${value.course.selling_price} </p>`
                                :`<p class="card-price text-black font-weight-bold">₦${value.course.discount_price} <span class="before-price font-weight-medium">₦${value.course.selling_price}</span></p>` 
                                }
                                <div class="icon-element icon-element-sm shadow-sm cursor-pointer" data-toggle="tooltip" data-placement="top" title="Remove from Wishlist" id="${value.id}" onclick="RemoveWishlist(this.id)"><i class="la la-heart"></i></div>
                            </div>
                        </div><!-- end card-body -->
                    </div><!-- end card -->
                </div><!-- end col-lg-4 -->
                `
            });

            $('#wishlist').html(rows)
          }
        })
    }
    wishlist();



    /// Start Remove WIshlist ///
    function RemoveWishlist(id){
        $.ajax({
            type: "GET",
            dataTyp: 'json',
            url: "/remove-wishlist/"+id,

            success: function(data){
                wishlist();
                // Start Message 
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end', 
                    showConfirmButton: false,
                    timer: 3000 
                })
                  
                if ($.isEmptyObject(data.error)) {

                    Toast.fire({
                    type: 'success',
                    icon: 'success',
                    title: data.success, 
                })

                }else{

                    Toast.fire({
                        type: 'error',
                        icon: 'error',
                        title: data.error,
                    })
                }
              // End Message  
            }
        })
    }
    /// End Remove Wishlist ///


</script>
{{-- End Load Wishlist Data  --}}




{{-- Start Cart function --}}
<script type="text/javascript">

    function addToCart(courseId, courseName, instructorId, slug){

        $.ajax({
            type: "POST",
            dataType: "json",
            data: {
                _token: '{{ csrf_token() }}',
                course_name: courseName,
                course_name_slug: slug,
                instructor: instructorId,
            },

            url: "/store/cart/data/"+ courseId,
            success: function(data){
                miniCart();
                // Start Message 
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end', 
                    showConfirmButton: false,
                    timer: 3000 
                })
                  
                if ($.isEmptyObject(data.error)) {

                    Toast.fire({
                    type: 'success',
                    icon: 'success',
                    title: data.success, 
                })

                }else{

                    Toast.fire({
                        type: 'error',
                        icon: 'error',
                        title: data.error,
                    })
                }
              // End Message   
            }
        })
    }

</script>
{{-- End Cart function --}}




{{-- Start Mini Cart function on Navbar --}}
<script type="text/javascript">

    function miniCart(){

        $.ajax({
            type: "GET",
            url: "/nav/cart/course/",
            dataType: "json",

            success: function(response){

                $('span[id="cartSubTotal"]').text(response.cartTotal);

                $('span[id="cartQty"]').text(response.cartQty);

                var miniCart = ""

                $.each(response.carts, function(key,value){
                    miniCart += `
                        <li class="media media-card">
                            <a href="shopping-cart.html" class="media-img">
                                <img src="/${value.options.image}" alt="Cart image">
                            </a>
                            <div class="media-body">
                                <h5><a href="/course/details/${value.id}/${value.options.slug}">${value.name}</a></h5>
                                
                                <span class="d-block fs-14">₦${value.price}</span>
                                <a type="submit" id="${value.rowId}" onclick="removeMiniCart(this.id)"><i class="la la-times"></i></a>
                            </div>
                        </li>
                    `
                });
                $('#miniCart').html(miniCart);
            }
        })
    }
    miniCart();



    /// Remove MiniCart function ///
    function removeMiniCart(rowId){
        $.ajax({
            type: "GET",
            url: "/remove/cart/course/"+rowId,
            dataType: "json",

            success: function(data){
                miniCart();
                // Start Message 
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end', 
                    showConfirmButton: false,
                    timer: 3000 
                })
                  
                if ($.isEmptyObject(data.error)) {

                    Toast.fire({
                    type: 'success',
                    icon: 'success',
                    title: data.success, 
                })

                }else{

                    Toast.fire({
                        type: 'error',
                        icon: 'error',
                        title: data.error,
                    })
                }
              // End Message 
            }
            
        })
    }
    /// End Remove MiniCart function ///


</script>
{{-- End Mini Cart function on Navbar --}}


{{-- Start Cart Page function --}}
<script type="text/javascript">
    function cart() {
        $.ajax({
            type: "GET",
            url: "/get-my-cart",
            dataType: "json",
            success: function(response) {

                $('span[id="cartSubTotal"]').text('₦' + response.cartTotal);

                var rows = "";
                $.each(response.carts, function(key, value) {
                    rows += `
                    <tr>
                        <th scope="row">
                            <div class="media media-card">
                                <a href="/course/details/${value.id}/${value.options.slug}" class="media-img mr-0">
                                    <img src="/${value.options.image}" alt="Cart image">
                                </a>
                            </div>
                        </th>
                        <td>
                            <a href="/course/details/${value.id}/${value.options.slug}" class="text-black font-weight-semi-bold">${value.name}</a>
                        </td>
                        <td>
                            <ul class="generic-list-item font-weight-semi-bold">
                                <li class="text-black lh-18">₦${value.price}</li>
                            </ul>
                        </td>

                        <td>
                            <button type="button" class="icon-element icon-element-xs shadow-sm border-0" data-toggle="tooltip" data-placement="top" title="Remove" id="${value.rowId}" onclick="removeCart(this.id)">
                                <i class="la la-times"></i>
                            </button>
                        </td>
                    </tr>
                    `;
                });
                $('#cartPage').html(rows);
            }
        });
    }

    cart();


    //Start Remove My Cart function ///
        function removeCart(rowId){
        $.ajax({
            type: "GET",
            url: "/remove-cart/"+rowId,
            dataType: "json",

            success: function(data){
                miniCart();
                cart();
                // Start Message 
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end', 
                    showConfirmButton: false,
                    timer: 3000 
                })
                  
                if ($.isEmptyObject(data.error)) {

                    Toast.fire({
                    type: 'success',
                    icon: 'success',
                    title: data.success, 
                })

                }else{

                    Toast.fire({
                        type: 'error',
                        icon: 'error',
                        title: data.error,
                    })
                }
              // End Message 
            }
            
        })
    }
    //End Remove My Cart function ///


</script>

{{-- End Cart Page function --}}