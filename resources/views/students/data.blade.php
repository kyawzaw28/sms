@forelse ($students as $student)
    <tr>
        <td scope="row" class="">{{ $student->name }}</td>
        <td>
            <p class="mb-0 d-block d-md-none"> {{ Str::limit($student->email, 15, '...') }} </p>
            <p class="mb-0 d-none d-md-block"> {{ $student->email }} </p>
            <p class="mb-0 text-black-50">{{ $student->phone }}</p>
        </td>
        <td class="d-none d-lg-table-cell">
            <p> {{ Str::limit($student->address, 50, '...') }} </p>
        </td>
        <td class=" align-middle text-center">
            {{-- <a href="{{ route('student.relatedPayment' , $student->id ) }}" class="btn table-btn-sm btn-primary" data-toggle="modal" data-target="#exampleModalCenter"> --}}

            <a href="#" class="btn table-btn-sm btn-primary showpaydata" data-bs-toggle="modal"
                data-bs-target="#exampleModalCenter" data-student="{{ $student->name }}" data-url-payment="{{ route('student.relatedPayment', $student->id) }}" onclick="showpaydata(event,{{$student->id}})">
                <i class="mdi mdi-credit-card-multiple h5"></i>
            </a>
        </td>
        {{-- Pyin --}}
        <td class=" align-middle text-center">
            {{-- <a href="{{ route('student.relatedClass' , $student->id ) }}" class="btn table-btn-sm btn-primary" data-toggle="modal" data-target="#exampleModalCenter">                                            
                                            <i class="mdi mdi-book-open-page-variant h5"></i>
                                        </a> --}}
            <a href="#" class="btn table-btn-sm btn-primary " onclick="showclassdata(event , {{ $student->id }})"
                data-student-name="{{ $student->name }}" data-bs-toggle="modal" data-bs-target="#classitemModal"
                data-url="{{ route('student.relatedPayment', $student->id) }}">
                <i class="mdi mdi-book-open-page-variant h5"></i>
            </a>
        </td>

        <td class="text-end align-middle text-nowrap">
            <div class="d-none d-md-block control-btns">
                <a href="{{ route('student.edit', $student->id) }}" class="btn table-btn-sm btn-primary">
                    <i class="mdi mdi-pencil h5"></i>
                </a>

                <form action="{{ route('student.destroy', $student->id) }}" class=" d-inline-block" method="post">
                    @csrf
                    @method('delete')
                    <button type="submit" class="btn table-btn-sm btn-danger del-btn alertbox">
                        <i class="mdi mdi-delete h5 text-white"></i>
                    </button>
                </form>


            </div>


            <div class="btn-group control-btn dropup d-block d-md-none ">
                <button type="button" class="btn table-btn-sm btn-outline-dark border border-0 dropdown-toggle"
                    data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="mdi mdi-dots-vertical h4"></i>
                </button>

                <ul class="dropdown-menu mb-1">
                    <div class="d-flex ">
                        <li>
                            <a href="{{ route('student.edit' , $student->id ) }}"
                                
                                class="btn table-btn-sm btn-outline-primary border border-0">
                                <i class="mdi mdi-pencil h5"></i>
                            </a>
                        </li>
                        <li>
                            <form action="{{ route('student.destroy' , $student->id ) }}" method="post">
                                @csrf
                                @method('delete')
                                <button type="submit" class="btn table-btn-sm btn-outline-danger border border-0">
                                    <i class="mdi mdi-delete h5 "></i>
                                </button>
                            </form>
                        </li>

                    </div>
                </ul>
            </div>
        </td>
    </tr>
@empty
    <td colspan="6" class="text-center">Data is Empty</td>
@endforelse

@push('scripts')
    <script>
        function classModal(response) {

            response.map(function(el) {
                let lecturers = [];
                el.users.map(function(el) {
                    lecturers += el.name + ',';
                });

                let price = el.price;



                $('.relatedClass').map(function() {
                    $(this).append(`
                                                        <tr>
                                                            <td>${el.name}</td>
                                                            <td>${el.course_name}</td>
                                                            <td>${lecturers}</td> 
                                                            <td>${Number(price).toLocaleString('en-Us')}</td>                                                                                                                                                                          
                                                        </tr>

                                                    `);
                });
            });

            console.log(response.length);
            if(response.length == 0){
                $('.relatedClass').append(`
                    <tr>
                        <td colspan="4" class="text-center text-danger fontsetting">No Class</td>
                    </tr>
                `);
            }
            $('#exampleModal').modal('show');

        };


        let classStudentName;

        function showclassdata(event, studentId) {

            classStudentName = event.currentTarget.getAttribute('data-student-name');
            $('.classStudentName').text(classStudentName);

            $.ajax({
                    url: "{{ route('classitems.get') }}?studentId=" + studentId,
                    type: "get",
                })
                .done(function(response) {
                    //    console.log(response);
                    classModal(response);
                })
                .fail(function(jqXHR, ajaxOptions, thrownError) {
                    console.log('Server error occured');
                });

            $('.relatedClass').empty();

            studentName = '';
        };

        // function validate() {

        //     let amount = Number(document.myForm.due_amount.value);
        //     paid = Number(paid);
        //     fees = Number(fees);
        //     if (amount > fees || amount > paid) {
        //         // console.log(amount , paid);                             
        //         $('.amount-error').text('This amount is exceeded');
        //         return false;
        //     };

        //     if (amount == '') {
        //         $('.amount-error').text('Amount is required');
        //         return false;
        //     };

        // };
    </script>
@endpush
