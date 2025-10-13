<script>
export default {
    data(){
        return{
        formdata : {
                    name:"",
                    email: "",
                    password:"",
                    password_confirmation:""
            }
        }
    },
    methods: {
        async formsubmit() {
            const token = document.querySelector('meta[name="csrf"]').content;
            
            const res = await fetch('api/signup', {
                method: 'post',
                headers: {
                    'X-CSRF-TOKEN': token,
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(this.formdata),
            });
            try {
                const data = await res.json();
                console.log(data);
            } catch (error) {
                console.log(error);
                
            }
            
            
            
        },
    },
};


</script>

<template>
    <div>
        <div id="div60">
        <div id="logo">
            <img src="../components/images/monkey.svg" style="width: 100%" />
        </div>
        <form @submit.prevent="formsubmit()" id="formdiv">
            <div id="formin">
                <label>type your name</label>
                <input type="text" name="name" v-model="formdata.name" class="textin"/>
            </div>
               
            <div id="formin">
                <label>type your email adress</label>
                <input type="text" name="email" v-model="formdata.email" class="textin"/>
            </div>

            <div id="formin">
                <label>type your password</label>
                <input type="password" name="password" v-model="formdata.password" class="textin"/>
            </div>

            <div id="formin">
                <label>confirm your password</label>
                <input type="password" name="password_confirmation" v-model="formdata.password_confirmation" class="textin"/>
            </div>

            <div>
                <button type="submit" id="buttonsub">Sign up</button>
            </div>
                

        </form>
        </div>
    </div>
</template>

<style scoped>
#div60{
     border: solid #408040;
     border-width: 0px 3px;
    box-shadow: 10px 0px 40px 10px rgba(83, 227, 147, 0.25),-10px 0px 40px 10px rgba(83, 227, 147, 0.25);
        width: max(60vw,500px);
            justify-self: center;
            height: 100vh;
}
#logo {
    justify-self: center;
    width: 200px;
    padding: 50px;
}
#formdiv {
    height: auto;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 30px;
}
#formin{
    display: flex;
    flex-direction: column;
    align-items: center;
    width: 80%;
    max-width: 300px;
    gap: 8px;
}
.textin{
    width: 100%;
    padding: 5px;
    font-size: 1rem;
}
#buttonsub{
    width: 80px;
    height: 30px;
    font-size: 1rem;
}
</style>
