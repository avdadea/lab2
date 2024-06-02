import React from "react"
import { blog } from "../../../dummydata"
import "./footer.css"

const Footer = () => {
  return (
    <>
      <section className='newsletter'>
        <div className='container flexSB'>
          <div className='left row'>
            <h1>Newsletter - Stay tuned and get the latest updates</h1>
            <span>Far far away, behind the word mountains</span>
          </div>
          <div className='right row'>
            <input type='text' placeholder='Enter email address' />
            <i className='fa fa-paper-plane'></i>
          </div>
        </div>
      </section>
      <footer>
        <div className='container padding'>
          <div className='box logo'>
            <h1>The School of Kosova</h1>
            <p>
              TSK does not discriminate on the basis of race, color, national or ethnic origin, sexual orientation, gender identity, or other characteristics protected by state!
            </p>
            <i className='fab fa-facebook-f icon'></i>
            <i className='fab fa-twitter icon'></i>
            <i className='fab fa-instagram icon'></i>
          </div>
          <div className='box link'>
            <h3>Explore</h3>
            <ul>
              <li>About Us</li>
              <li>Services</li>
              <li>Courses</li>
              <li>Blog</li>
              <li>Contact us</li>
            </ul>
          </div>
          <div className='box last'>
            <h3>Have a Questions?</h3>
            <ul>
              <li>
                <i className='fa fa-map'></i>
                10 Dardani St., Mountain View, Prishtine, Kosove
              </li>
              <li>
                <i className='fa fa-phone-alt'></i>
                +38344123123
              </li>
              <li>
                <i className='fa fa-paper-plane'></i>
                info@tsk.com
              </li>
            </ul>
          </div>
        </div>
      </footer>
      <div className='legal'>
        <p>Copyright ©2024 All rights reserved</p>
      </div>
    </>
  )
}

export default Footer
