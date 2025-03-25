<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { Link } from '@inertiajs/vue3';
</script>


<template>
        <!-- <div>
            <Link href="/">
                <ApplicationLogo class="h-20 w-20 fill-current text-gray-500" />
            </Link>
        </div> -->
    <div class="bg-image"
        style="
        background-image: url('https://storage.googleapis.com/limecube-live-c29b24b1/root/Blog/business-partners-illustration.jpg');
        height: 100vh;
        position: relative;
        top: 0px;
        left: 20px; 
        overflow: hidden;
        background-repeat: no-repeat;
        background-position: right center;
        background-size: auto 100%;
        ">
    <form>
        <!-- LOGIN FORM -->
        <div>
            <div
                class="mt-0 w-full overflow-hidden bg-white px-6 py-4 shadow-md sm:max-w-md sm:rounded-lg"
            >
            <div class="col-lg-6 d-flex align-items-center gradient-custom-2">
            <img src="https://www.dubaiweighing.com/wp-content/uploads/2022/03/truck-scale.jpg"
            alt="Login image" class="w-100 vh-100" style="object-fit: cover; object-position: left;">
            </div>
            <div class="rounded-md text-sm">
                <h5 class="fw-normal mb-3 pb-3" style="letter-spacing: 1px; font-size: 2.5rem;font-weight: bold;">Welcome back</h5> 
            <div class="col-sm-6 px-0 d-none d-sm-block">
        </div>
    </div>
                <slot />
            </div>
        </div>
    </form>                                    
    </div> 
    </template>    


