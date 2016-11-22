class LoginFormFields extends React.Component {
    render() {
        return (
            <div>
                <h2 className="form-signin-heading">Please sign in</h2>
                <label for="inputUsername" className="sr-only">Username</label>
                <input type="username" id="inputUsername" className="form-control" placeholder="Username" required autofocus defaultValue="test" />
                <label for="inputPassword" className="sr-only">Password</label>
                <input type="password" id="inputPassword" className="form-control" placeholder="Password" required defaultValue="asd123" />
            </div>
        );
    }
}