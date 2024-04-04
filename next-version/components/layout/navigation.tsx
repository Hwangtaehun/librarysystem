"use client";

import Container from 'react-bootstrap/Container';
import Nav from 'react-bootstrap/Nav';
import Navbar from 'react-bootstrap/Navbar';
import NavDropdown from 'react-bootstrap/NavDropdown';
import { Menu } from "./menu";

export default function Navigation(){
    var c_menu: Menu = new Menu();
    var state = c_menu.get_state();

    if(state == '1'){
        return (
            <Navbar expand="lg" className="bg-body-tertiary">
                <Container>
                    <Navbar.Brand></Navbar.Brand>
                    <Navbar.Toggle aria-controls="basic-navbar-nav" />
                    <Navbar.Collapse id="basic-navbar-nav">
                        <Nav className="me-auto">
                            <Nav.Link href="/">홈</Nav.Link>
                            <NavDropdown title="Dropdown" id="basic-nav-dropdown">
                                {c_menu.makeArray('공지사항')}
                            </NavDropdown>
                            <NavDropdown title="Dropdown" id="basic-nav-dropdown">
                                {c_menu.makeArray('책')}
                            </NavDropdown>
                            <NavDropdown title="Dropdown" id="basic-nav-dropdown">
                                {c_menu.makeArray('종류')}
                            </NavDropdown>
                            <NavDropdown title="Dropdown" id="basic-nav-dropdown">
                                {c_menu.makeArray('도서관')}
                            </NavDropdown>
                            <NavDropdown title="Dropdown" id="basic-nav-dropdown">
                                {c_menu.makeArray('자료')}
                            </NavDropdown>
                            <NavDropdown title="Dropdown" id="basic-nav-dropdown">
                                {c_menu.makeArray('대출')}
                            </NavDropdown>
                            <NavDropdown title="Dropdown" id="basic-nav-dropdown">
                                {c_menu.makeArray('상호대차')}
                            </NavDropdown>
                            <NavDropdown title="Dropdown" id="basic-nav-dropdown">
                                {c_menu.makeArray('기타')}
                            </NavDropdown>
                        </Nav>
                    </Navbar.Collapse>
                </Container>
            </Navbar>
        );
    }
    else{
        return(
            <Navbar expand="lg" className="bg-body-tertiary">
                <Container>
                    <Navbar.Brand></Navbar.Brand>
                    <Navbar.Toggle aria-controls="basic-navbar-nav" />
                    <Navbar.Collapse id="basic-navbar-nav">
                        <Nav className="me-auto">
                            <Nav.Link href="/">홈</Nav.Link>
                            <Nav.Link href="/not/list">공지사항</Nav.Link>
                            <Nav.Link href="/lib/list">도서관</Nav.Link>
                            <Nav.Link href="/mat/list">자료 검색</Nav.Link>
                            <NavDropdown title="내서재" id="basic-nav-dropdown">
                                { c_menu.makeArray('내서재') }
                            </NavDropdown>
                            <NavDropdown title="내정보수정" id="basic-nav-dropdown">
                                { c_menu.makeArray('내정보수정') }
                            </NavDropdown>
                        </Nav>
                    </Navbar.Collapse>
                </Container>
            </Navbar>
        );
    }
}