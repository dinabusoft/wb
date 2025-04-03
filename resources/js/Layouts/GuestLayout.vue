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
        background-image: url('https://img.freepik.com/free-vector/code-snippets-concept-illustration_114360-4681.jpg?t=st=1743651966~exp=1743655566~hmac=e8e021f2505341d7bb9862ea4721f80ac04957ab07ef614b2bf3530f08fa0523&w=826');
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
            <img src="https://img.freepik.com/free-vector/code-typing-concept-illustration_114360-4296.jpg?t=st=1743652045~exp=1743655645~hmac=507bab7624f10d770d5abfe8cdf3ce84edc8055749397749061d4dd8b276c252&w=826"
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


