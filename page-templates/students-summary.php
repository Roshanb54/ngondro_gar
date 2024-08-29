<?php

/**
 * Template Name: Student Summary Page
 */

get_header('loggedin');
?>

<div id="layoutSidenav_content">
    <div class="container px-sm-1 px-10">
        <div class="row">
            <div class="row mt-10">
                <div class="col-md-10 offset-md-1">
                    <div class="d-flex align-items-center">
                        <div class="d-flex align-items-center justify-content-center me-2">
                            <i class="icon feather icon-user"></i>
                        </div>
                        <h3 class="fw-bold mb-0"><?php echo __('Student Summary','ngondro_gar');?></h3>
                    </div>
                </div>
            </div>
            <div class="row ">
                <div class="col-md-5 offset-md-1">
                    <div class="sidebar-inner-box" style="min-height:500px;">
                        <div class="student-summary-filter-bar d-flex justify-content-between mb-2">
                            <!--<a href="#">Reported</a>
                            <a href="#">Missed</a>
                            <a href="#">Graduated</a>-->
                            <nav>
                                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                    <button class="nav-link active" id="nav-reported-tab" data-bs-toggle="tab" data-bs-target="#nav-course" type="button" role="tab" aria-controls="nav-course" aria-selected="true">
                                        <?php echo __('Reported','ngondro_gar');?>
                                    </button>
                                    <button class="nav-link" id="nav-missed-tab" data-bs-toggle="tab" data-bs-target="#nav-understanding" type="button" role="tab" aria-controls="nav-understanding" aria-selected="false">
                                    <?php echo __('Missed','ngondro_gar');?>
                                    </button>
                                    <button class="nav-link" id="nav-graduated-tab" data-bs-toggle="tab" data-bs-target="#nav-graduated" type="button" role="tab" aria-controls="nav-reports" aria-selected="false">
                                    <?php echo __('Graduated','ngondro_gar');?>
                                    </button>
                                </div>
                            </nav>
                            <div class="tab-content" id="nav-tabContent"> 
                                <div class="tab-pane fade show active" id="nav-reported" role="tabpanel" aria-labelledby="nav-reported-tab" tabindex="0">
                                    <div class="student-summary-bar-chart d-flex justify-content-around">
                                        <div class="text-center">
                                            <svg width="66" height="234" viewBox="0 0 66 234" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <rect x="0.694336" width="64.9913" height="233.974" rx="4" fill="#F3F3F3"/>
                                                <path d="M0.694336 200.549H65.6856V229.974C65.6856 232.183 63.8947 233.974 61.6856 233.974H4.69434C2.4852 233.974 0.694336 232.183 0.694336 229.974V200.549Z" fill="#BD5D72"/>
                                            </svg>
                                            <p class="mt-2">10%</p>
                                            <p>On Track</p>
                                            <strong>448</strong>
                                        </div>
                                        <div class="text-center">
                                            <svg width="66" height="234" viewBox="0 0 66 234" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <rect x="0.248993" width="64.9913" height="233.974" rx="4" fill="#F3F3F3"/>
                                                <path d="M0.248993 137.71H65.2403V229.974C65.2403 232.183 63.4494 233.974 61.2403 233.974H4.24899C2.03985 233.974 0.248993 232.183 0.248993 229.974V137.71Z" fill="#E6C99A"/>
                                            </svg>
                                            <p class="mt-2">10%</p>
                                            <p>On Track</p>
                                            <strong>448</strong>
                                        </div>
                                        <div class="text-center">
                                            <svg width="66" height="234" viewBox="0 0 66 234" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <rect x="0.694336" width="64.9913" height="233.974" rx="4" fill="#F3F3F3"/>
                                                <path d="M0.711861 113.645H65.7031V229.974C65.7031 232.183 63.9123 233.974 61.7031 233.974H4.71186C2.50272 233.974 0.711861 232.183 0.711861 229.974V113.645Z" fill="#651A55"/>
                                            </svg>
                                            <p class="mt-2">10%</p>
                                            <p>On Track</p>
                                            <strong>448</strong>
                                        </div>

                                    </div>
                                </div>
                                <div class="tab-pane fade" id="nav-missed" role="tabpanel" aria-labelledby="nav-missed-tab" tabindex="0">
                                    <div class="student-summary-bar-chart d-flex justify-content-around">
                                        <div class="text-center">
                                            <svg width="66" height="234" viewBox="0 0 66 234" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <rect x="0.694336" width="64.9913" height="233.974" rx="4" fill="#F3F3F3"/>
                                                <path d="M0.694336 200.549H65.6856V229.974C65.6856 232.183 63.8947 233.974 61.6856 233.974H4.69434C2.4852 233.974 0.694336 232.183 0.694336 229.974V200.549Z" fill="#BD5D72"/>
                                            </svg>
                                            <p class="mt-2">10%</p>
                                            <p>On Track</p>
                                            <strong>448</strong>
                                        </div>
                                        <div class="text-center">
                                            <svg width="66" height="234" viewBox="0 0 66 234" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <rect x="0.248993" width="64.9913" height="233.974" rx="4" fill="#F3F3F3"/>
                                                <path d="M0.248993 137.71H65.2403V229.974C65.2403 232.183 63.4494 233.974 61.2403 233.974H4.24899C2.03985 233.974 0.248993 232.183 0.248993 229.974V137.71Z" fill="#E6C99A"/>
                                            </svg>
                                            <p class="mt-2">10%</p>
                                            <p>On Track</p>
                                            <strong>448</strong>
                                        </div>
                                        <div class="text-center">
                                            <svg width="66" height="234" viewBox="0 0 66 234" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <rect x="0.694336" width="64.9913" height="233.974" rx="4" fill="#F3F3F3"/>
                                                <path d="M0.711861 113.645H65.7031V229.974C65.7031 232.183 63.9123 233.974 61.7031 233.974H4.71186C2.50272 233.974 0.711861 232.183 0.711861 229.974V113.645Z" fill="#651A55"/>
                                            </svg>
                                            <p class="mt-2">10%</p>
                                            <p>On Track</p>
                                            <strong>448</strong>
                                        </div>

                                    </div>
                                </div>
                                <div class="tab-pane fade" id="nav-graduated" role="tabpanel" aria-labelledby="nav-graduated-tab" tabindex="0">
                                    <div class="student-summary-bar-chart d-flex justify-content-around">
                                        <div class="text-center">
                                            <svg width="66" height="234" viewBox="0 0 66 234" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <rect x="0.694336" width="64.9913" height="233.974" rx="4" fill="#F3F3F3"/>
                                                <path d="M0.694336 200.549H65.6856V229.974C65.6856 232.183 63.8947 233.974 61.6856 233.974H4.69434C2.4852 233.974 0.694336 232.183 0.694336 229.974V200.549Z" fill="#BD5D72"/>
                                            </svg>
                                            <p class="mt-2">10%</p>
                                            <p>On Track</p>
                                            <strong>448</strong>
                                        </div>
                                        <div class="text-center">
                                            <svg width="66" height="234" viewBox="0 0 66 234" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <rect x="0.248993" width="64.9913" height="233.974" rx="4" fill="#F3F3F3"/>
                                                <path d="M0.248993 137.71H65.2403V229.974C65.2403 232.183 63.4494 233.974 61.2403 233.974H4.24899C2.03985 233.974 0.248993 232.183 0.248993 229.974V137.71Z" fill="#E6C99A"/>
                                            </svg>
                                            <p class="mt-2">10%</p>
                                            <p>On Track</p>
                                            <strong>448</strong>
                                        </div>
                                        <div class="text-center">
                                            <svg width="66" height="234" viewBox="0 0 66 234" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <rect x="0.694336" width="64.9913" height="233.974" rx="4" fill="#F3F3F3"/>
                                                <path d="M0.711861 113.645H65.7031V229.974C65.7031 232.183 63.9123 233.974 61.7031 233.974H4.71186C2.50272 233.974 0.711861 232.183 0.711861 229.974V113.645Z" fill="#651A55"/>
                                            </svg>
                                            <p class="mt-2">10%</p>
                                            <p>On Track</p>
                                            <strong>448</strong>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="sidebar-inner-box" style="min-height:500px;">
                        <div class="student-summary-filter-bar d-flex justify-content-between mb-2">
                            <a href="#"><?php echo __('Overall','ngondro_gar');?></a>
                            <a href="#"><?php echo __('By Curriculum','ngondro_gar');?> </a>
                            <a href="#"><?php echo __('By Language','ngondro_gar');?></a>
                        </div>
                        <div class="student-summary-doughnut-chart text-center">
                            <svg width="240" height="241" viewBox="0 0 240 241" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M240 120.758C240 146.801 231.527 172.138 215.861 192.943C200.195 213.747 178.185 228.891 153.156 236.086C128.126 243.282 101.435 242.14 77.1112 232.832C52.7878 223.524 32.1529 206.555 18.3216 184.488L120 120.758H240Z" fill="#BD5D72"/>
                                <path d="M82.4513 6.78372C100.499 0.837937 119.701 -0.736959 138.476 2.18865C157.251 5.11426 175.063 12.4567 190.446 23.6118C205.829 34.7668 218.343 49.4154 226.958 66.3521C235.573 83.2887 240.043 102.029 240 121.031L120 120.758L82.4513 6.78372Z" fill="#CFB58B"/>
                                <path d="M23.2171 191.702C12.0214 176.429 4.59933 158.722 1.55783 140.031C-1.48367 121.34 -0.0582777 102.194 5.71746 84.1586C11.4932 66.1236 21.4553 49.7116 34.7892 36.2645C48.1232 22.8173 64.4504 12.7168 82.4359 6.78879L120 120.758L23.2171 191.702Z" fill="#BD5D72"/>
                                <path d="M152.228 63.5127C152.228 64.1707 152.095 64.7422 151.83 65.2274C151.564 65.7125 151.198 66.1113 150.733 66.4237C150.274 66.7294 149.743 66.9487 149.138 67.0816V67.1514C150.301 67.2976 151.178 67.6632 151.77 68.248C152.368 68.8329 152.667 69.6071 152.667 70.5708C152.667 71.4148 152.464 72.1692 152.059 72.8338C151.653 73.4917 151.032 74.0101 150.195 74.389C149.357 74.7678 148.281 74.9572 146.965 74.9572C146.174 74.9572 145.439 74.8941 144.761 74.7678C144.09 74.6415 143.452 74.4388 142.847 74.1597V72.0761C143.465 72.3818 144.123 72.6178 144.821 72.7839C145.519 72.9501 146.18 73.0332 146.805 73.0332C148.021 73.0332 148.889 72.8072 149.407 72.3553C149.925 71.8967 150.185 71.2653 150.185 70.4611C150.185 69.9427 150.048 69.5174 149.776 69.1851C149.51 68.8528 149.095 68.6036 148.53 68.4374C147.971 68.2713 147.25 68.1882 146.366 68.1882H145.08V66.304H146.376C147.22 66.304 147.898 66.2043 148.41 66.005C148.922 65.7989 149.291 65.5165 149.517 65.1576C149.749 64.7987 149.866 64.38 149.866 63.9015C149.866 63.2768 149.663 62.7916 149.257 62.446C148.852 62.0938 148.251 61.9176 147.453 61.9176C146.961 61.9176 146.513 61.9741 146.107 62.0871C145.708 62.2001 145.34 62.343 145.001 62.5158C144.662 62.6886 144.339 62.8747 144.034 63.0741L142.907 61.4491C143.459 61.037 144.117 60.6881 144.881 60.4023C145.645 60.1166 146.536 59.9737 147.553 59.9737C149.048 59.9737 150.201 60.296 151.012 60.9407C151.823 61.5787 152.228 62.436 152.228 63.5127ZM164.715 67.4604C164.715 68.6368 164.622 69.6902 164.436 70.6206C164.257 71.5444 163.971 72.3287 163.579 72.9733C163.187 73.618 162.675 74.1098 162.044 74.4488C161.412 74.7877 160.648 74.9572 159.751 74.9572C158.628 74.9572 157.7 74.6614 156.969 74.0699C156.238 73.4718 155.697 72.6145 155.344 71.4979C154.992 70.3747 154.816 69.0289 154.816 67.4604C154.816 65.892 154.976 64.5495 155.295 63.4329C155.62 62.3098 156.145 61.4491 156.87 60.851C157.594 60.2528 158.554 59.9537 159.751 59.9537C160.881 59.9537 161.811 60.2528 162.542 60.851C163.28 61.4425 163.825 62.2998 164.177 63.423C164.536 64.5395 164.715 65.8853 164.715 67.4604ZM157.179 67.4604C157.179 68.69 157.258 69.7168 157.418 70.5409C157.584 71.365 157.857 71.9831 158.235 72.3951C158.614 72.8006 159.119 73.0033 159.751 73.0033C160.382 73.0033 160.887 72.8006 161.266 72.3951C161.645 71.9897 161.917 71.375 162.083 70.5509C162.256 69.7268 162.343 68.6966 162.343 67.4604C162.343 66.2376 162.26 65.2141 162.093 64.39C161.927 63.5659 161.655 62.9478 161.276 62.5357C160.897 62.117 160.389 61.9077 159.751 61.9077C159.113 61.9077 158.604 62.117 158.225 62.5357C157.853 62.9478 157.584 63.5659 157.418 64.39C157.258 65.2141 157.179 66.2376 157.179 67.4604ZM169.885 59.9737C170.955 59.9737 171.766 60.3724 172.317 61.17C172.869 61.9608 173.145 63.0807 173.145 64.5295C173.145 65.9717 172.879 67.0982 172.347 67.9091C171.822 68.7199 171.002 69.1253 169.885 69.1253C168.842 69.1253 168.047 68.7199 167.502 67.9091C166.957 67.0982 166.685 65.9717 166.685 64.5295C166.685 63.0807 166.941 61.9608 167.453 61.17C167.971 60.3724 168.782 59.9737 169.885 59.9737ZM169.895 61.6086C169.463 61.6086 169.144 61.8512 168.938 62.3363C168.739 62.8215 168.639 63.5559 168.639 64.5395C168.639 65.5165 168.739 66.2542 168.938 66.7526C169.144 67.2445 169.463 67.4904 169.895 67.4904C170.334 67.4904 170.659 67.2445 170.872 66.7526C171.091 66.2608 171.201 65.5231 171.201 64.5395C171.201 63.5625 171.095 62.8315 170.882 62.3463C170.669 61.8545 170.34 61.6086 169.895 61.6086ZM179.675 60.183L171.59 74.7578H169.666L177.751 60.183H179.675ZM179.405 65.8056C180.475 65.8056 181.286 66.2043 181.838 67.0019C182.396 67.7928 182.675 68.9126 182.675 70.3615C182.675 71.797 182.409 72.9202 181.878 73.731C181.353 74.5418 180.529 74.9472 179.405 74.9472C178.362 74.9472 177.568 74.5418 177.023 73.731C176.478 72.9202 176.205 71.797 176.205 70.3615C176.205 68.9126 176.461 67.7928 176.973 67.0019C177.491 66.2043 178.302 65.8056 179.405 65.8056ZM179.415 67.4405C178.983 67.4405 178.664 67.6831 178.458 68.1683C178.259 68.6534 178.159 69.3878 178.159 70.3714C178.159 71.3484 178.259 72.0861 178.458 72.5846C178.664 73.0764 178.983 73.3223 179.415 73.3223C179.861 73.3223 180.19 73.0797 180.402 72.5945C180.615 72.1027 180.721 71.3617 180.721 70.3714C180.721 69.3945 180.615 68.6634 180.402 68.1782C180.19 67.6864 179.861 67.4405 179.415 67.4405Z" fill="white"/>
                                <path d="M68.582 173.758L74.3042 161.237H66.7377V159.183H76.8264V160.788L71.1042 173.758H68.582ZM88.7153 166.46C88.7153 167.637 88.6223 168.69 88.4362 169.621C88.2567 170.544 87.9709 171.329 87.5788 171.973C87.1867 172.618 86.675 173.11 86.0436 173.449C85.4122 173.788 84.6479 173.957 83.7507 173.957C82.6275 173.957 81.7004 173.661 80.9693 173.07C80.2383 172.472 79.6966 171.614 79.3444 170.498C78.9921 169.375 78.816 168.029 78.816 166.46C78.816 164.892 78.9755 163.549 79.2945 162.433C79.6202 161.31 80.1452 160.449 80.8696 159.851C81.5941 159.253 82.5544 158.954 83.7507 158.954C84.8805 158.954 85.811 159.253 86.542 159.851C87.2797 160.442 87.8247 161.3 88.177 162.423C88.5359 163.54 88.7153 164.885 88.7153 166.46ZM81.1787 166.46C81.1787 167.69 81.2584 168.717 81.4179 169.541C81.5841 170.365 81.8566 170.983 82.2354 171.395C82.6142 171.801 83.1193 172.003 83.7507 172.003C84.3821 172.003 84.8872 171.801 85.266 171.395C85.6448 170.99 85.9173 170.375 86.0835 169.551C86.2563 168.727 86.3427 167.697 86.3427 166.46C86.3427 165.238 86.2596 164.214 86.0934 163.39C85.9273 162.566 85.6548 161.948 85.276 161.536C84.8971 161.117 84.3887 160.908 83.7507 160.908C83.1127 160.908 82.6043 161.117 82.2254 161.536C81.8532 161.948 81.5841 162.566 81.4179 163.39C81.2584 164.214 81.1787 165.238 81.1787 166.46ZM93.885 158.974C94.955 158.974 95.7659 159.372 96.3175 160.17C96.8691 160.961 97.1449 162.081 97.1449 163.53C97.1449 164.972 96.8791 166.098 96.3474 166.909C95.8223 167.72 95.0016 168.125 93.885 168.125C92.8416 168.125 92.0474 167.72 91.5024 166.909C90.9574 166.098 90.6849 164.972 90.6849 163.53C90.6849 162.081 90.9408 160.961 91.4526 160.17C91.971 159.372 92.7818 158.974 93.885 158.974ZM93.895 160.609C93.463 160.609 93.144 160.851 92.938 161.336C92.7386 161.822 92.6389 162.556 92.6389 163.54C92.6389 164.516 92.7386 165.254 92.938 165.753C93.144 166.244 93.463 166.49 93.895 166.49C94.3336 166.49 94.6593 166.244 94.872 165.753C95.0913 165.261 95.2009 164.523 95.2009 163.54C95.2009 162.563 95.0946 161.831 94.8819 161.346C94.6693 160.855 94.3403 160.609 93.895 160.609ZM103.675 159.183L95.5897 173.758H93.6657L101.751 159.183H103.675ZM103.405 164.806C104.475 164.806 105.286 165.204 105.838 166.002C106.396 166.793 106.675 167.913 106.675 169.361C106.675 170.797 106.409 171.92 105.878 172.731C105.353 173.542 104.529 173.947 103.405 173.947C102.362 173.947 101.568 173.542 101.023 172.731C100.478 171.92 100.205 170.797 100.205 169.361C100.205 167.913 100.461 166.793 100.973 166.002C101.491 165.204 102.302 164.806 103.405 164.806ZM103.415 166.441C102.983 166.441 102.664 166.683 102.458 167.168C102.259 167.653 102.159 168.388 102.159 169.371C102.159 170.348 102.259 171.086 102.458 171.585C102.664 172.076 102.983 172.322 103.415 172.322C103.861 172.322 104.19 172.08 104.402 171.595C104.615 171.103 104.721 170.362 104.721 169.371C104.721 168.394 104.615 167.663 104.402 167.178C104.19 166.686 103.861 166.441 103.415 166.441Z" fill="white"/>
                            </svg>
                            <div class="legends">
                                <div class="d-flex mr-4">
                                    <span class="legend-label total-student-legend"></span>
                                    <span><?php echo __('Total Sudents:','ngondro_gar');?></span><span>1850</span>

                                </div>
                                <div class="d-flex">
                                    <span class="legend-label reported-legend"></span>
                                    <span><?php echo __('Reoprted:','ngondro_gar');?></span><span>1696</span>
                                </div>

                            </div>
                            <p>Out of <strong>1850</strong> students <strong>1696</strong> have reported <strong>1,527,451</strong> practice hours including <strong>24,953</strong> transfer hours</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="curriculum-row mt-7">
                <div class="col-md-10 offset-1">
                    <div class="sidebar-inner-box">
                        <h6 class="fw-bold"><?php echo __('Count of students in each curriculum and section','ngondro_gar');?></h6>
                        <nav>
                            <div class="nav nav-tabs" id="nav-count" role="tablist">
                                <button class="nav-link active" id="nav-lnn-tab" data-bs-toggle="tab" data-bs-target="#nav-lnn" type="button" role="tab" aria-controls="nav-lnn" aria-selected="true">
                                    LNN
                                </button>
                                <button class="nav-link" id="nav-cnn-tab" data-bs-toggle="tab" data-bs-target="#nav-cnn" type="button" role="tab" aria-controls="nav-cnn" aria-selected="false">
                                    CNN
                                </button>
                                <button class="nav-link" id="nav-kmn-tab" data-bs-toggle="tab" data-bs-target="#nav-kmn" type="button" role="tab" aria-controls="nav-kmn" aria-selected="false">
                                    KMN
                                </button>
                            </div>
                        </nav>
                        <div class="tab-content" id="nav-tabContent">
                            <div class="tab-pane fade show active py-5" id="nav-lnn" role="tabpanel" aria-labelledby="nav-lnn-tab" tabindex="0">
                                <div class="table-responsive">
                                    <table class="table table-borderless">
                                        <thead>
                                            <th><?php echo __('Exempt','ngondro_gar');?></th>
                                            <th><?php echo __('No Report','ngondro_gar');?></th>
                                            <th><?php echo __('Preliminary','ngondro_gar');?></th>
                                            <th><?php echo __('Refuge & Bodichitta','ngondro_gar');?></th>
                                            <th><?php echo __('Vajrasattva','ngondro_gar');?></th>
                                            <th><?php echo __('Mandala','ngondro_gar');?></th>
                                            <th><?php echo __('Guru Yoga','ngondro_gar');?></th>
                                            <th><?php echo __('Done','ngondro_gar');?></th>
                                            <th><?php echo __('Grad','ngondro_gar');?></th>
                                            <th><?php echo __('Total','ngondro_gar');?></th>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>0</td>
                                                <td>112</td>
                                                <td>112</td>
                                                <td>112</td>
                                                <td>112</td>
                                                <td>112</td>
                                                <td>112</td>
                                                <td>112</td>
                                                <td>112</td>
                                                <td>112</td>
                                            </tr>
                                            <tr>
                                                <td>0</td>
                                                <td>112</td>
                                                <td>112</td>
                                                <td>112</td>
                                                <td>112</td>
                                                <td>112</td>
                                                <td>112</td>
                                                <td>112</td>
                                                <td>112</td>
                                                <td>112</td>
                                            </tr>
                                        </tbody>

                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane fade py-5" id="nav-cnn" role="tabpanel" aria-labelledby="nav-cnn-tab" tabindex="0">
                                <div class="table-responsive">
                                    <table class="table table-borderless">
                                        <thead>
                                        <th><?php echo __('Exempt','ngondro_gar');?></th>
                                        <th><?php echo __('No Report','ngondro_gar');?></th>
                                        <th><?php echo __('Preliminary','ngondro_gar');?></th>
                                        <th><?php echo __('Refuge & Bodichitta','ngondro_gar');?></th>
                                        <th><?php echo __('Vajrasattva','ngondro_gar');?></th>
                                        <th><?php echo __('Mandala','ngondro_gar');?></th>
                                        <th><?php echo __('Guru Yoga','ngondro_gar');?></th>
                                        <th><?php echo __('Done','ngondro_gar');?></th>
                                        <th><?php echo __('Grad','ngondro_gar');?></th>
                                        <th><?php echo __('Total','ngondro_gar');?></th>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td>0</td>
                                            <td>112</td>
                                            <td>112</td>
                                            <td>112</td>
                                            <td>112</td>
                                            <td>112</td>
                                            <td>112</td>
                                            <td>112</td>
                                            <td>112</td>
                                            <td>112</td>
                                        </tr>
                                        <tr>
                                            <td>0</td>
                                            <td>112</td>
                                            <td>112</td>
                                            <td>112</td>
                                            <td>112</td>
                                            <td>112</td>
                                            <td>112</td>
                                            <td>112</td>
                                            <td>112</td>
                                            <td>112</td>
                                        </tr>
                                        </tbody>

                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane fade py-5" id="nav-kmn" role="tabpanel" aria-labelledby="nav-kmn-tab" tabindex="0">
                                <div class="table-responsive">
                                    <table class="table table-borderless">
                                        <thead>
                                        <th><?php echo __('Exempt','ngondro_gar');?></th>
                                        <th><?php echo __('No Report','ngondro_gar');?></th>
                                        <th><?php echo __('Preliminary','ngondro_gar');?></th>
                                        <th><?php echo __('Refuge & Bodichitta','ngondro_gar');?></th>
                                        <th><?php echo __('Vajrasattva','ngondro_gar');?></th>
                                        <th><?php echo __('Mandala','ngondro_gar');?></th>
                                        <th><?php echo __('Guru Yoga','ngondro_gar');?></th>
                                        <th><?php echo __('Done','ngondro_gar');?></th>
                                        <th><?php echo __('Grad','ngondro_gar');?></th>
                                        <th><?php echo __('Total','ngondro_gar');?></th>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td>0</td>
                                            <td>112</td>
                                            <td>112</td>
                                            <td>112</td>
                                            <td>112</td>
                                            <td>112</td>
                                            <td>112</td>
                                            <td>112</td>
                                            <td>112</td>
                                            <td>112</td>
                                        </tr>
                                        <tr>
                                            <td>0</td>
                                            <td>112</td>
                                            <td>112</td>
                                            <td>112</td>
                                            <td>112</td>
                                            <td>112</td>
                                            <td>112</td>
                                            <td>112</td>
                                            <td>112</td>
                                            <td>112</td>
                                        </tr>
                                        </tbody>

                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php get_footer() ?>
</div>