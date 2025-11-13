<template>
    <div id="headernavmain">
        <div id="headleftside">
            <router-link to="/" id="chimprankrouter" class="button">
                <p id="chimprank">ChimpRank</p>
                <img src="../components/images/monkey.svg" alt="icon" id="chimpranklogo" />
            </router-link>

            <div id="headnavlink">
                <router-link to="/products" id="headlink" class="button" @mouseenter="preloadproducts"
                    >Products</router-link
                >

                <router-link to="/solutions" id="headlink" class="button" @mouseenter="preloadsolutions"
                    >Solutions</router-link
                >

                <router-link to="/resources" id="headlink" class="button" @mouseenter="preloadresources"
                    >Resources</router-link
                >

                <router-link to="/pricing" id="headlink" class="button" @mouseenter="preloadpricing"
                    >Pricing</router-link
                >
            </div>
        </div>
        <div>
            <router-link to="/signup" id="signupbutton" class="button">Sign Up</router-link>
        </div>
    </div>
</template>

<script setup>
</script>

<style scoped>
#headernavmain {
    padding: 0px 30px;
    display: flex;
    align-items: center;
    box-shadow: 0 1px 2px 0 hsla(0, 0%, 100%, 0.1);
    z-index: 2;
    background-color: hsl(210, 40%, 20%);
}
#headleftside {
    display: flex;
    align-items: center;
    flex: 2;
}
#headnavlink {
    margin-left: 100px;
}
#headleftside .link-active-chimp {
    color: rgb(218, 218, 218);
}
#headlink {
    padding: 20px;
    color: #969696;
}
#signupbutton,
#demobutton{
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
#demobutton {
    background-color: #1f1f1f;
    color: #d8d8d8;
}
#chimprankrouter {
    width: 200px;
    height: 100px;
    display: flex;
}
#chimprank {
    font-size: 30px;
    font-weight: 600;
    margin-top: 40px;
}
#chimpranklogo {
    position: relative;
    right: 7px;
    height: 50px;
    margin-top: 20px;
}
</style>
