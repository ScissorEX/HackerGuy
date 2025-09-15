<template>
    <div id="headernavmain">
        <div id="headleftside">

            <router-link to="/" id="chimprankrouter">
                <video height="200" id="chimprank" autoplay loop>
                    <source src="../components/images/chimprank.mkv" type="video/mp4" />
                </video>
        </router-link>

            <div id="headnavlink">
                <router-link to="/products" id="headlink">Products</router-link>

                <router-link to="/solutions" id="headlink">Solutions</router-link>

                <router-link to="/resources" id="headlink">Resources</router-link>

                <router-link to="/pricing" id="headlink">Pricing</router-link>
            </div>
        </div>
        <div>
            for dev=>
            <router-link to="/requestdemo" id="demobutton">Request Demo</router-link>
            <router-link to="/signup" id="signupbutton">Sign Up</router-link>
        </div>
    </div>
</template>

<script setup>
</script>

<style scoped>
#headernavmain {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    margin-top: 0;
    padding: 0px 30px;
    color: white;
    display: flex;
    align-items: center;
    box-shadow: 0 1px 2px 0 hsla(0, 0%, 100%, 0.1);
    z-index: 2;
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
#headlink,
#signupbutton,
#demobutton {
    text-decoration: none;
}
#headlink {
    padding: 20px;
    color: #969696;
}
#signupbutton,
#demobutton {
    padding: 5px 10px;
    border-radius: 7px;
    margin: 2px;
}
#signupbutton {
    background-color: #00e199;
    color: #072c09;
}
#demobutton {
    background-color: #1f1f1f;
    color: #d8d8d8;
}
#chimprankrouter{
    object-fit:cover;
    width: 200px;
    height: 100px;
    overflow: hidden;
}
#chimprank{
    margin-left: -80px;
    margin-top: -35px;
}
</style>
