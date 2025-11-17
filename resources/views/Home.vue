<template>
    <div id="homediv1">
        <div id="humanchimpdiv">
            <h1 style="background-image: radial-gradient(circle, #484848, #2b2b2b 50%)">The future</h1>
            <h1 style="background-image: radial-gradient(circle, #4c4c4c, #1f1f1f 70%)">of development</h1>
            <h1 style="background-image: radial-gradient(circle, #ffffff 50%, #5b5b5b)">
                is
                <img
                    src="../components/images/icons/fingerprint-svgrepo-com.min.svg"
                    style="width: 75px; transform: rotate(10deg)" />human +
                <img src="../components/images/icons/monkey-svgrepo-com.min.min.svg" style="width: 75px" />Chimp
            </h1>
            <p>theres a text here lol</p>
            <div style="margin: 80px">
                <router-link to="/community" id="communityjoin" class="button"> Join The Community</router-link>
            </div>
        </div>
    </div>
    <div id="homediv2" class="whitebgc">
        <div id="adventurediv">
            <h2>Choose Your <span style="color: #24ae65">Adventure</span></h2>
            <p>We build elite simian teams for companies and enhance candidates primate skills and job prospects</p>
        </div>
        <div id="twocardatonce" class="blackbgc">
            <div id="fordevcard">
                <div>
                    <h3>For developers</h3>
                    <p>ChimpRank helps you hone your primal skills and become Ape-Ready</p>
                </div>
                <ul>
                    <li>Track your skill proficiency</li>
                    <li>Prepare for technical interviews</li>
                    <li>Learn the latest ape skills</li>
                </ul>
                <a id="explorecommunitybutton" class="whitebgc">Explore ChimpRank Community</a>
            </div>
            <div id="forbusinesscard">
                <div>
                    <h3>For business</h3>
                    <p>Get your troop Ape-Ready</p>
                </div>
                <ul>
                    <li>Attract and hire the right monkeys</li>
                    <li>Upskill your team with the latest ape skills</li>
                    <li>Build out your monkey platform skills</li>
                </ul>
                <a id="exploretheotherbutton">Explore ChimpRank Community</a>
            </div>
        </div>
        <div>
            <div>
                <h1>
                    Life-Changing <br />
                    Pack Development
                </h1>
            </div>
            d
        </div>
    </div>
</template>

<script setup></script>

<style scoped>
#homediv1 {
    display: flex;
    justify-content: center;
    margin: 200px 0 300px;
}
#homediv2 {
    background-color: #fff;
    border-radius: 70px;
    height: 2000px;
}
h1 {
    font-weight: 500;
    font-size: 100px;
    word-spacing: -5px;
    letter-spacing: -5px;
    margin: -30px;
    color: transparent;
    background-clip: text;
}
#humanchimpdiv {
    justify-items: center;
    height: 600px;
}
#adventurediv {
    justify-items: center;
    padding-top: 200px;
}
p {
    font-size: 12px;
}
h2 {
    font-weight: 400;
    font-size: 35px;
}

#twocardatonce {
    display: flex;
    justify-content: center;
}
#fordevcard,
#forbusinesscard {
    background: #050b07;
    background: linear-gradient(45deg, #050b07, #101a13);
    border-radius: 15px;
    padding: 10px 30px 40px 30px;
    margin: 10px 7px;
}
#explorecommunitybutton,
#exploretheotherbutton,
#communityjoin {
    padding: 15px 30px;
    border-radius: 7px;
}
#explorecommunitybutton {
    background-color: #53e393;
}
#exploretheotherbutton {
    background-color: #1c2221;
}
#communityjoin {
    border: solid #222623;
    box-shadow: 0px 5px 40px 0px rgba(83, 227, 147, 0.25);
}
</style>
