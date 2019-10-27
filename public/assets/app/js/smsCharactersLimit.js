let content;

jQuery(document).ready(function () {

    $('#').keydown(function () {
        var tweet_length = this.val().length;
        if(tweet_length &gt; 10) {
            this.val(this.substring(0,10));
        }
    });

});




