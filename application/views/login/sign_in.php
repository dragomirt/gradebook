<div class="row">
    <div class="col-md-4 col-xs-12 loginLeft">
        <?php echo form_open('login/sign_in', array('class'=>'loginForm')); ?> 
            <div>
                <div>
                    <label for="title">Name</label> 
                    <input type="text" name="title" /><br /> 
                </div>
                <div>
                    <label for="text">Password</label> 
                    <input type='password' name="password" /><br /> 
                </div>
                <input type="hidden" name="submit" /> 
                <button class="loginButton">LOG IN</button>
            </div>
        </form>
    </div>
    <div class="col-md-8 col-xs-12 loginRight">
        <div id="loginParticles"></div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/particles.js@2.0.0/particles.min.js"></script>
<script>
    particlesJS.load('loginParticles', '../../../static/json/particles.json', function() {
        console.log('callback - particles.js config loaded');
    });
</script>