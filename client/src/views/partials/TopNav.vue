<template>
    <header class="shadow" :class="[ $auth.check() ? 'px-4 py-2' : 'p-4' ]">
        <nav class="flex items-center">
            <router-link 
                :to="{ name: 'home' }"
                class="no-underline text-grey-darkest font-semibold text-2xl"
            >Paul's LMS</router-link>

            <ul class="list-reset ml-auto flex items-center">
                <template v-if="$auth.check()">
                    <dropdown>
                        <dropdown-button 
                            :text="$auth.user().name" 
                            dropdown-id="navbarDropdown1" 
                            slot="button"
                        ></dropdown-button>

                        <dropdown-menu slot="menu" dropdown-id="navbarDropdown1">
                            <dropdown-menu-item to="dashboard">Dashboard</dropdown-menu-item>
                            <dropdown-menu-item :logout="true">Logout</dropdown-menu-item>  
                        </dropdown-menu>
                    </dropdown>
                </template>
                
                <template v-else>
                    <li v-if="!$auth.check()" class="ml-4">
                        <router-link :to="{ name: 'login' }">Login</router-link>
                    </li>

                    <li v-if="!$auth.check()" class="ml-4">
                        <router-link :to="{ name: 'register' }">Register</router-link>
                    </li>
                </template>
            </ul>
        </nav>
    </header>
</template>