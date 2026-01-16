@extends('layouts.guest')
@section('title', 'Hyper FAQs | IT Solutions, Software Development & Cloud Services')
@section('og-title', 'Hyper FAQs | IT Solutions, Software Development & Cloud Services')
@section('meta-desc', 'Find answers to common questions about Hyper’s IT services, including software development, cloud solutions, cybersecurity, and IT consulting.')
@section('og-desc', 'Find answers to common questions about Hyper’s IT services, including software development, cloud solutions, cybersecurity, and IT consulting.')
@section('og-type', 'website')
@section('meta-keywords', 'Hyper IT company FAQ, IT services FAQ, software development questions, cloud solutions questions, cybersecurity FAQ, IT consulting questions, technology solutions FAQ')
@section('content')
    <section class="hero-section hero-sm">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-5">
                    <div class="mt-md-4">
                        <h2 class="text-white fw-normal mb-2 hero-title">
                            Frequently Asked Questions
                        </h2>
                        <p class="mb-3 font-16 text-white-50">Helpful answers and guidance to make your experience seamless.
                        </p>
                    </div>
                </div>
                <div class="col-md-5 offset-md-2 d-none d-md-block">
                    <div class="text-md-end mt-3 mt-md-0">
                        <img src="{{ asset('assets/images/frequently-asked-questions.svg') }}" alt=""
                            class="img-fluid" style="max-width: 60%" />
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="text-center">
                        <h1 class="mt-0"><i class="mdi mdi-frequently-asked-questions"></i></h1>
                        <h3>Frequently Asked <span class="text-primary">Questions</span></h3>
                        <p class=mt-2">Here are some of the basic types of questions for our customers. For
                            more
                            <br>information please contact us.
                        </p>

                        <button type="button" class="btn btn-success btn-sm mt-2"><i
                                class="mdi mdi-email-outline me-1"></i> Email us your question</button>
                        <button type="button" class="btn btn-info btn-sm mt-2 ms-1"><i class="mdi mdi-twitter me-1"></i>
                            Send us a tweet</button>
                    </div>
                </div>
            </div>

            <div class="row mt-5">
                <div class="col-lg-5 offset-lg-1">
                    <!-- Question/Answer -->
                    <div>
                        <div class="faq-question-q-box">Q.</div>
                        <h4 class="faq-question text-body">Can I use this template for my client?</h4>
                        <p class="faq-answer mb-4 pb-1">Yup, the marketplace license allows you to use this
                            theme
                            in any end products.
                            For more information on licenses, please refere <a
                                href="https://themes.getbootstrap.com/licenses/" target="_blank">here</a>.</p>
                    </div>

                    <!-- Question/Answer -->
                    <div>
                        <div class="faq-question-q-box">Q.</div>
                        <h4 class="faq-question text-body">How do I get help with the theme?</h4>
                        <p class="faq-answer mb-4 pb-1">Use our dedicated support email
                            (support@coderthemes.com) to send your issues or feedback. We are here to help anytime.</p>
                    </div>

                </div>
                <!--/col-lg-5 -->

                <div class="col-lg-5">
                    <!-- Question/Answer -->
                    <div>
                        <div class="faq-question-q-box">Q.</div>
                        <h4 class="faq-question text-body">Can this theme work with Wordpress?</h4>
                        <p class="faq-answer mb-4 pb-1">No. This is a HTML template. It won't directly with
                            wordpress, though you can convert this into wordpress compatible theme.</p>
                    </div>

                    <!-- Question/Answer -->
                    <div>
                        <div class="faq-question-q-box">Q.</div>
                        <h4 class="faq-question text-body">Will you regularly give updates of Hyper?</h4>
                        <p class="faq-answer mb-4 pb-1">Yes, We will update the Hyper regularly. All the
                            future updates would be available without any cost.</p>
                    </div>

                </div>
                <!--/col-lg-5-->
            </div>
            <!-- end row -->

        </div> <!-- end container-->
    </section>
@endsection
