import React from "react"
import Back from "../common/back/Back"
import "./contact.css"
import { useState } from "react";

const Contact = () => {
  const map = 'https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d904726.6131739549!2d85.24565535!3d27.65273865!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sen!2snp!4v1652535615693!5m2!1sen!2snp" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade" '
 
  const [fullName, setFullName] = useState("");
  const [subject, setSubject] = useState("");
  const [emailAddress, setEmailAddress] = useState("");
  const [message, setMessage] = useState("");

  const handleContact = async (event) => {
    event.preventDefault();

    try {
      const response = await fetch("http://localhost:8080/contact", {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify({
          fullName,
          subject,
          emailAddress,
          message,
        }),
      });

      if (response.ok) {
        console.log("Message sent successfully");
        // Optionally, reset form fields after successful submission
        setFullName("");
        setSubject("");
        setEmailAddress("");
        setMessage("");
      } else {
        console.error("Failed to send message");
      }
    } catch (error) {
      console.error("Error sending message:", error);
    }
  };



  return (
    <>
      <Back title='Contact us' />
      <section className='contacts padding'>
        <div className='container shadow flexSB'>
          <div className='left row'>
            <iframe src={map}></iframe>
          </div>
          <div className='right row'>
            <h1>Contact us</h1>
            <p>We're open for any suggestion or just to have a chat</p>

            <div className='items grid2'>
              <div className='box'>
                <h4>ADDRESS:</h4>
                <p>198 West 21th Street, Suite 721 Prishtine </p>
              </div>
              <div className='box'>
                <h4>EMAIL:</h4>
                <p> info@tsk.com</p>
              </div>
              <div className='box'>
                <h4>PHONE:</h4>
                <p> + 383 44 123 123</p>
              </div>
            </div>

            <form>
              <div className='flexSB'>
                <input type='text' onChange={(e) => setFullName(e.target.value)} placeholder='Name' />
                <input type='email' onChange={(e) => setEmailAddress(e.target.value)} placeholder='Email' />
              </div>
              <input type='text' onChange={(e) => setSubject(e.target.value)}  placeholder='Subject' />
              <textarea cols='30' rows='10' onChange={(e) => setMessage(e.target.value)} placeholder="Message">
                
              </textarea>
              <button type="submit" onClick={handleContact} className='primary-btn'>SEND MESSAGE</button>
            </form>

            <h3>Follow us here</h3>
            <span>FACEBOOK TWITTER INSTAGRAM DRIBBBLE</span>
          </div>
        </div>
      </section>
    </>
  )
}

export default Contact
