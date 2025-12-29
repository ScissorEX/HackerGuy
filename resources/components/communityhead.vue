<template>
    <div id="biggestheader">
        <div id="headernavmain">
            <router-link to="/" id="chimprankrouter" class="button">
                <p id="chimprank">ChimpRank</p>
                <img src="../components/images/icons/monkey.svg" alt="icon" id="chimpranklogo" />
            </router-link>

            <div id="headnavlink">
                <img src="../components/images/icons/search.svg" id="searchicon" />
                <input id="searchbar" />
            </div>
            <div>
                <router-link to="/signup" id="signupbutton" class="button">Sign Up</router-link>
            </div>
            <div id="avatar" @click="dropdownmenu = !dropdownmenu">
                <img src="/resources/components/images/icons/avatar.svg" style="width: 35px;">
            </div>
            <div v-if="dropdownmenu" id="dropdownmenu">
                    hello
                </div>
        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue';

const dropdownmenu = ref(true);

</script>

<style scoped>
#biggestheader {
    width: 100%;
    background-color: #1f3347;
    justify-items: center;
    box-shadow: 0 1px 2px 0 hsla(0, 0%, 100%, 0.1);
}

#headernavmain {
    padding: 0px 30px;
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 2;
    width: 50%;
}

#headnavlink {
    margin: 0 30px;
    padding: 1px 50px 1px 25px;
    border-radius: 15px;
    background-color: hsl(210, 83%, 74%);
    display: flex;
    justify-content: space-between;
    width: 600px;
    border: solid 2px #192939;
}

#searchbar {
    text-decoration: none;
    padding: 1px 3px;
    margin: 0;
    width: 100%;
    background-color: transparent;
    border: none;
    box-shadow: none;
    color: inherit;
    outline: none;
    appearance: none;
    font-family: 'Roboto', 'Arial', sans-serif;
    font-size: 1.3rem;
    line-height: 2rem;
}

#signupbutton{
    padding: 7px 15px;
    border-radius: 7px;
    margin: 2px;
    border: none;
    font-weight: 400;
    font-size: 16px;
    cursor: pointer;
}

#signupbutton {
    background-color: #00e199;
    color: #072c09;
}
#chimprankrouter {
    width: 120px;
    height: 50px;
    display: flex;
}

#chimprank {
    font-size: 15px;
    font-weight: 600;
    margin-top: 22px;
}

#chimpranklogo {
    position: relative;
    right: 7px;
    height: 30px;
    margin-top: 7px;
}
#avatar{
    background-color: white;
    width: 35px;
    height: 35px;
    border-radius: 50%;
}
#dropdownmenu{
    position: fixed;
    top: 50px;
    left: 70%;
    background-color: rgb(252, 200, 200);
}
</style>
